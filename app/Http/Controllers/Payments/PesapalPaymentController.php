<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment as PaymentModel;
use App\Traits\UpdatesPaymentStatus;
use Bryceandy\Laravel_Pesapal\Facades\Pesapal;
use Bryceandy\Laravel_Pesapal\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PesapalPaymentController extends Controller
{

    use UpdatesPaymentStatus;

    function __invoke($invoice_number){

        $invoice = Invoice::where('id', $invoice_number)->first();
        if($invoice == null){
            return back()->withErrors(['status' => 'The invoice does not exist']);
        }

        if($invoice->isPaid()){
            return $this->json->error('The invoice has already been paid for');
        }

        if($invoice->hasPendingPayment()){
            return $this->json->error("There's already another pending payment for this invoice. Please wait a few minutes and try again");
        }

        $user = $this->user();

        $details = array(
            'amount' => $invoice->total,
            // 'amount' => number_format(1, 2),
            'description' => 'Invoice Payment',
            'first_name' => $user->name,
            'last_name' => '',
            'email' => $user->email,
            'phone_number' => $user->phone,
            'reference' => $invoice->id,
            'currency' => 'KES'
        );


        Payment::create($details);

        $iframe_src = Pesapal::getIframeSource(array_merge($details, [
            'type' => 'MERCHANT',
        ]));

        return view('web.billing.pesapal.iframe', compact('iframe_src'));

    }

    function callback(Request $request){
        $transaction = Pesapal::getTransactionDetails(
            request('pesapal_merchant_reference'), request('pesapal_transaction_tracking_id')
        );

        // Store the paymentMethod, trackingId and status in the database
        Payment::modify($transaction);

        $status = $transaction['status'];

        $payment = PaymentModel::where('invoice_id', request('pesapal_merchant_reference'))
            ->latest('time')
            ->first();

        $invoice = $this->user()
            ->invoices()
            ->where('invoices.id', request('pesapal_merchant_reference'))
            ->first();

        if(!$payment){
            $payment = new PaymentModel([
                'invoice_id' => request('pesapal_merchant_reference'),
                'amount' => $invoice->total ?? 0,
                'method' => PaymentModel::METHOD_PESAPAL,
                'generated' => 'System'
            ]);
        }

        $this->updatePesapalPaymentStatus($payment, $status);

        // also $status = Pesapal::statusByTrackingIdAndMerchantRef(request('pesapal_merchant_reference'), request('pesapal_transaction_tracking_id'));
        // also $status = Pesapal::statusByMerchantRef(request('pesapal_merchant_reference'));

        return $this->view('web.billing.pesapal.received', compact('status')); // Display this status to the user. Values are (PENDING, COMPLETED, INVALID, or FAILED)
    }

}
