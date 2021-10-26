<?php

namespace App\Http\Controllers\Platform\Billing;

use App\Http\Controllers\Controller;
use App\Helpers\ResultSet;
use App\Models\Advert;
use Illuminate\Http\Request;

class InvoicesController extends Controller {
    function __invoke(Request $request){
        $query = $this->user()
            ->invoices()
            ->whereHas('advert');

        // Status
        if($request->get('status') == 'paid') $query->paid();
        elseif($request->get('status') == 'unpaid') $query->unpaid();
        elseif($request->get('status') == 'overdue') $query->overdue();

        // Date
        if($request->filled('date_range')){
            $dates = explode('to', preg_replace("/ +to +/", "", $request->filled('date_range')));

            $from = $dates[0];
            $to = $dates[1];

            $query->between($from, $to);
        }

        // Order
        if($request->filled('order')){
            $order = $request->get('order');
            if($order == 'oldest') $query->oldest();
            else if($order == 'highest') $query->highest();
            else if($order == 'lowest') $query->lowest();
            else $query->latest();
        }else{
            $query->latest();
        }

        // Fetch the result
        $result = new ResultSet($query, 20);

        return $this->view('web.billing.invoices', [
            'result' => $result,
        ]);
    }
}
