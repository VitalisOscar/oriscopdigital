<?php

namespace App\Traits;

use App\Models\Payment;
use App\Services\DebugService;
use Exception;

trait UpdatesPaymentStatus{
    function updatePesapalPaymentStatus($payment, $new_status){
        $new_status = strtolower($new_status);

        if($new_status == 'pending'){
            $new_status = Payment::STATUS_PENDING;
        }else if($new_status == 'complete'){
            $new_status = Payment::STATUS_SUCCESS;
        }else{
            $new_status = Payment::STATUS_FAILED;
        }

        $payment->status = $new_status;

        try{
            return $payment->save();
        }catch(Exception $e){
            DebugService::catch($e);
            return false;
        }
    }
}
