<?php

namespace App\Http\Controllers\Admin\Billing;

use App\Exports\ExcelExport;
use App\Helpers\ResultSet;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\StaffLog;
use App\Repository\InvoiceRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    function getAll(Request $request){
        $invoices = Invoice::query();


        if($request->filled('number')){
            $invoices->where('invoices.id', $request->get('number'));
        }

        if($request->filled('status')){

            if($request->get('status') == 'paid'){
                $invoices->paid();
            }else if($request->get('status') == 'overdue'){
                $invoices->overDue();
            }else if($request->get('status') == 'post_pay'){
                $invoices->unPaid()->postPay();
            }

        }

        $range = $request->get('date_range');
        if($range != null){

            $range = explode(' to ', $range);

            $from = $range[0];
            $to = $from;

            if(count($range) > 1){
                $to = $range[1];
            }

            $invoices->where(function($q) use($from, $to){
                $q->whereBetween('invoices.created_at', [$from, $to])
                    ->orWhereDate('invoices.created_at', $from)
                    ->orWhereDate('invoices.created_at', $to);
            });
        }

        $order = $request->get('order');
        if($order == 'oldest') $invoices->oldest();
        else if($order == 'highest') $invoices->highest();
        else if($order == 'lowest') $invoices->lowest();
        else $invoices->latest();

        $invoices->with([
            'successful_payment', 'advert', 'advert.user'
        ]);


        return $this->view('admin.billing.invoices', [
            'result' => new ResultSet($invoices, 20)
        ]);
    }

    function getSingle($number){
        $invoice = Invoice::whereId($number)->first();

        return $this->view('admin.billing.single_invoice', [
            'invoice' => $invoice,
            'payment_methods' => Payment::OTHER_METHODS
        ]);
    }

    function confirmPayment(Request $request, $number){
        $invoice = Invoice::where('id', $number)->first();

        $payment = new Payment([
            'invoice_id' => $invoice->id,
            'method' => $request->post('method'),
            'code' => $request->post('code'),
            'generated' => 'admin',
            'status' => Payment::STATUS_SUCCESS,
            'amount' => $invoice->total
        ]);

        if($payment->save()){
            return back()->with([
                'status' => 'The invoice has been marked as paid'
            ]);
        }

        return back()->withErrors([
            'status' => 'Something went wrong. Please try again'
        ]);
    }

    function export(InvoiceRepository $repository){
        $filename = 'invoices_'.str_replace('-', '_', Carbon::now()->format('Y-m-d')).'.pdf';

        return Excel::download(new ExcelExport($repository->getQuery(), Invoice::exportHeaders()), $filename);
    }

    function asFile($invoice_number){
        $invoice = Invoice::where('id', $invoice_number)
            ->with('advert', 'advert.user')
            ->first();

        $pdf_name = 'Invoice_'.$invoice->number.'.pdf';

        $pdf = PDF::loadView('docs.invoice_tabled', [
            'invoice' => $invoice
        ]);

        return $pdf->stream($pdf_name, array("Attachment" => false));;
    }
}
