<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Http\Controllers\Controller;
use App\Mail\AdvertApprovedMail;
use App\Mail\AdvertRejectedMail;
use App\Models\Advert;
use App\Services\DebugService;
use App\Traits\CreatesInvoices;
use App\Traits\SendsEmails;
use App\Traits\SendsSMS;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SingleAdvertController extends Controller
{

    use SendsEmails, SendsSMS, CreatesInvoices;

    function approve($id)
    {
        $advert = Advert::where('id', $id)->with(['user'])->first();

        try{
            // Approve ad
            $advert->status = Advert::STATUS_APPROVED;

            // Create invoice
            $invoice = $this->createInvoice($advert);

            DB::beginTransaction();
            if ($invoice->save() && $advert->save()) {
                DB::commit();

                // send email
                $this->sendEmail(new AdvertApprovedMail($advert->user, $advert->invoice, $advert));

                // send sms
                $this->sendSMS($advert->user->phone, 'Your ad, \'' . $advert->description . '\' has been approved. Log onto your ' . config('app.name') . ' account and find it under Approved Ads section');

                return back()->with([
                    'status' => 'Advert has been approved. Client has been notified by the system'
                ]);
            }
        }catch(Exception $e){
            DebugService::catch($e);
        }

        DB::rollback();
        return back()->withErrors([
            'status' => 'Something went wrong. Please try again'
        ]);
    }

    function reject(Request $request, $id)
    {
        if (!$request->filled('reason')) {
            return back()->withErrors([
                'status' => 'Please specify a reason for declining ad'
            ]);
        }

        $advert = Advert::where('id', $id)->first();
        $reason = $request->post('reason');

        $advert->status = Advert::STATUS_REJECTED;

        if ($advert->save()) {
            // send email
            $this->sendEmail(new AdvertRejectedMail($advert->user, $advert, $reason));

            // send sms
            $this->sendSMS($advert->user->phone, 'Your ad, \'' . $advert->description . '\' has been declined. Check your email for details about why this happenned');

            return back()->with([
                'status' => 'Advert has been declined. Client has been notified by the system'
            ]);
        }

        return back()->withErrors([
            'status' => 'Something went wrong. Please try again'
        ]);
    }
}
