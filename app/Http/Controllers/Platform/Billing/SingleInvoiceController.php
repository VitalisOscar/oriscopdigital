<?php

namespace App\Http\Controllers\Platform\Billing;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;

class SingleInvoiceController extends Controller {
    function __invoke($invoice_number){
        $invoice = $this->user()
            ->invoices()
            ->where('invoices.id', $invoice_number)
            ->first();

        return $this->view('web.billing.single_invoice', [
            'invoice' => $invoice,
            'number' => $invoice_number,
        ]);
    }

    function asFile($invoice_number){
        $invoice = $this->user()
            ->invoices()
            ->where('invoices.id', $invoice_number)
            ->first();

        $pdf_name = 'Invoice_'.$invoice->number.'.pdf';

        $pdf = PDF::loadView('docs.invoice_tabled', [
            'invoice' => $invoice
        ]);

        return $pdf->stream($pdf_name, array("Attachment" => false));;
    }

    function pay($invoice_number){
        $invoice = $this->user()
            ->invoices()
            ->where('invoices.id', $invoice_number)
            ->first();

        if($invoice == null){
            return back()->withErrors([
                'status' => 'Payment cannot be initiated. The respective invoice does not exist under your account'
            ]);
        }

        return redirect()->route('pesapal.payment', $invoice->number);
    }
}
