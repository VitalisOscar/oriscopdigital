<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Http\Controllers\Controller;
use App\Mail\AccountApprovedMail;
use App\Mail\AccountRejectedMail;
use App\Models\User;
use App\Traits\SendsEmails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SingleClientController extends Controller
{
    use SendsEmails;

    function get($email){
        $client = User::where('email', $email)->first();

        return $this->view('admin.clients.single', [
            'client' => $client
        ]);
    }

    function viewKraPin($email){
        $client = User::where('email', $email)->first();

        $doc = $client->kra_pin_document;
        if($doc == null){
            return back()->withErrors(['status' => 'KRA Pin document for this client was not uploaded during registration']);
        }

        return response()->file(storage_path($doc));
    }

    function viewCertificate($email){
        $client = User::where('email', $email)->first();

        $doc = $client->business_certificate;
        if($doc == null){
            return back()->withErrors(['status' => 'Business/Incorporation certificate for this client was not uploaded during registration']);
        }

        return response()->file(storage_path($doc));
    }

    function verify($email){
        $client = User::where('email', $email)->first();

        if($client->isApproved()){
            return back()->withErrors([
                'status' => 'Client account is already verified'
            ]);
        }

        $verification = $client->verification;

        $verification['business'] = Carbon::now()->toString();
        $client->status = User::STATUS_APPROVED;

        $client->verification = $verification;

        if(!$client->save()){
            return back()->withErrors(['status' => 'Something went wrong. Please try again']);
        }

        DB::commit();

        // send email
        $this->sendEmail(new AccountApprovedMail($client));

        return back()->with(['status' => 'Client account is now verified']);
    }

    function reject($email){
        $client = User::where('email', $email)->first();

        if($client->isRejected()){
            return back()->withErrors([
                'status' => 'Client account is already rejected'
            ]);
        }

        $verification = $client->verification;

        $verification['business'] = null;

        $client->status = User::STATUS_REJECTED;
        $client->verification = $verification;

        if(!$client->save()){
            return back()->withErrors(['status' => 'Something went wrong. Please try again']);
        }

        // send email
        $this->sendEmail(new AccountRejectedMail($client));

        return back()->with(['status' => 'Client account has been rejected']);
    }

    function addPostPay(Request $request, $email){
        $validator = validator()->make($request->post(), [
            'limit' => ['required', 'numeric', 'min:0']
        ]);

        if($validator->fails()) return back()->withErrors(['status' => 'Please specify a valid limit for the client']);

        $client = User::where('email', $email)->first();

        $payments = $client->payments;
        $payments['post_pay'] = true;
        $payments['post_pay_limit'] = $request->post('limit');
        $client->payments = $payments;

        if(!$client->save()) return back()->withErrors(['status' => 'Something went wrong. Please try again']);

        // Send email

        return back()->with(['status' => 'Account has been added to post pay clients']);
    }

    function removePostPay($email){
        $client = User::where('email', $email)->first();

        $payments = $client->payments;
        $payments['post_pay'] = false;
        $payments['post_pay_limit'] = 0;
        $client->payments = $payments;

        if(!$client->save()) return back()->withErrors(['status' => 'Something went wrong. Please try again']);

        // TODO send user notification
        return back()->with(['status' => 'Account has been removed from post pay clients']);
    }
}
