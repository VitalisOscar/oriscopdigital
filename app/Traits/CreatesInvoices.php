<?php

namespace App\Traits;

use App\Models\Advert;
use App\Models\Invoice;
use Carbon\Carbon;

trait CreatesInvoices{
    /**
     * Create a new invoice
     * @param Advert $advert
     * @return Invoice
     */
    function createInvoice($advert){

        $amount = 0;

        $first_date = now()->format('Y-m-d');

        $advert->load('bookings');

        foreach($advert->bookings as $booking){
            $amount += $booking->price;

            foreach($booking->all_dates as $date){
                if($date < $first_date){
                    $first_date = $date;
                }
            }
        }

        $tax_rate = 16;
        $tax = ($amount * $tax_rate) / 100;


        $due_date = Carbon::createFromFormat('Y-m-d', $first_date);
        $due_date->addDays($advert->user->post_pay_limit);

        $invoice = new Invoice([
            'advert_id' => $advert->id,
            'tax' => [
                'rate' => $tax_rate,
                'amount' => $tax,
            ],
            'amount' => $amount,
            'due_date' => $due_date->format('Y-m-d')
        ]);

        return $invoice;
    }
}
