<?php

namespace App\Http\Controllers\Platform\Account\Manage;

use App\Http\Controllers\Controller;
use App\Helpers\ResultSet;
use App\Models\Advert;
use App\Services\DebugService;
use App\Traits\SendsSMS;
use Exception;
use Illuminate\Http\Request;

class VerifyPhoneController extends Controller {
    use SendsSMS;

    function sendCode(){
        $user = $this->user();

        // Check if verified
        if($user->hasPhoneVerified()){
            return back()->withErrors([
                'status' => 'Your phone number is already verified'
            ]);
        }

        $code = $user->getPhoneCode();

        if(!$code){
            // Error occurred
            return back()->withErrors([
                'status' => 'Something went wrong. Please try again'
            ]);
        }

        // Send the message
        if(!$this->sendSMS(
            $user->phone,
            'Use the code '.$code.' to verify your phone number'
        )){
            // SMS not sent
            return back()->withErrors([
                'status' => 'A server error occured. Please try again or send feedback if this persists'
            ]);
        }

        // Success
        return back()->with([
            'get_code' => 'A verification code has been sent to the business phone number',
            'expiry' => config('auth.phone_verification_expiry')
        ]);
    }

    function verifyCode(Request $request){
        if(!$request->filled('code')){
            // Hey, we need that code
            return back()->withInput()->withErrors([
                'code' => 'Please enter the verification code you received',
                'get_code' => ''
            ]);
        }

        $user = $this->user();

        $code = $request->post('code');

        try{
            // Validate
            if(!$user->validatePhoneCode($code)){
                // Oops. Invalid code
                return back()->withInput()->withErrors([
                    'code' => 'The provided code is invalid',
                    'status_phone' => false
                ]);
            }

            // Verify phone
            if(!$user->verifyPhone()){
                // Oops. Something wrong
                return back()->withInput()->withErrors([
                    'code' => 'Something went wrong. Please try again',
                    'status_phone' => false
                ]);
            }

            // Done
            return back()->with([
                'status_phone' => true
            ]);
        }catch(Exception $e){
            DebugService::catch($e);
            return back()->withInput()->withErrors([
                'code' => 'Something went wrong. Please try again',
                'status_phone' => false
            ]);
        }
    }
}
