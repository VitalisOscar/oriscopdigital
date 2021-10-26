<?php

namespace App\Traits;

use App\Services\DebugService;
use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

trait SendsEmails{

    /**
     * Send an SMS message
     * @param Mailable $mail
     * @return bool|string
     */
    function sendEmail($mail){
        if(config('mail.fake')){
            Mail::fake()->send($mail);
            return true;
        }

        try{
            Mail::send($mail);
            return true;
        }catch(Exception $e){
            DebugService::catch($e);
            return false;
        }
    }
}
