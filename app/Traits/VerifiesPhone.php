<?php

namespace App\Traits;

use App\Models\PhoneVerification;
use App\Services\DebugService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait VerifiesPhone{

    /**
     * Get the id of the account verifying phone
     */
    abstract function getAccountId();

    /**
     * Get the type of the account verifying phone
     */
    abstract function getAccountType();

    /**
     * Mark an account as phone verified
     */
    abstract function markAsPhoneVerified();

    /**
     * Get cache storage key
     */
    function getCacheKey(){
        return 'verify_phone_'.$this->getAccountType().'_'.$this->getAccountId();
    }

    /**
     * Generate phone verification code
     * @return string|false
     */
    function getPhoneCode(){
        // Check if the user has a non-expired code
        $code = Cache::get($this->getCacheKey());

        if($code != null){
            return $code;
        }

        // Create a code
        try{
            $code = rand(100000, 999999);

            if(Cache::put(
                $this->getCacheKey(),
                $code,
                Carbon::now()->addMinutes(config('auth.phone_verification_expiry'))
            )){
                return $code;
            }

            return false;
        }catch(Exception $e){
            DebugService::catch($e);
        }

        return false;
    }

    /**
     * Verify a phone using a code
     * @param string $code Verification code
     * @return string|false
     */
    function validatePhoneCode($code){
        return Cache::get($this->getCacheKey()) == $code;
    }

    /**
     * Complete phone verification
     * @return bool
     */
    function verifyPhone(){
        $this->markAsPhoneVerified();

        try{
            // Delete generated code
            if(Cache::pull($this->getCacheKey())){
                return true;
            }
        }catch(Exception $e){
            DebugService::catch($e);
        }

        return false;
    }
}
