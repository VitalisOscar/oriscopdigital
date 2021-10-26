<?php

namespace App\Models;

use App\Services\DebugService;
use App\Traits\VerifiesPhone;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, VerifiesPhone;

    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_PENDING = 'pending';

    const DOCUMENT_DIR_KRA = 'clients/documents/kra_pins';
    const DOCUMENT_DIR_CERT = 'clients/documents/certificates';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'verification', // (email, phone, business)
        'payments',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification'
    ];

    protected $casts = [
        'verification' => 'array',
        'payments' => 'array',
        'created_at' => 'datetime'
    ];

    protected $appends = [
        'email_verified_at', 'phone_verified_at', 'business_verified_at',
        'registered_at'
    ];

    function adverts(){
        return $this->hasMany(Advert::class);
    }

    function invoices(){
        return $this->hasManyThrough(Invoice::class, Advert::class);
    }

    // Verifies phone trait abstract functions
    function getAccountId(){
        return $this->id;
    }

    function getAccountType(){
        return 'user';
    }

    function markAsPhoneVerified(){
        $verification = $this->verification;
        $verification['phone'] = Carbon::now()->toDateTimeString();

        $this->verification = $verification;

        $this->save();
    }

    // attributes
    function getPostPayLimitAttribute(){
        if($this->isPrePay()){
            return 0;
        }

        return $this->payments['post_pay_limit'] ?? 0;
    }

    function getOperatorNameAttribute(){
        // return $this->operator['name'];
        return $this->name;
    }

    function getOperatorPhoneAttribute(){
        // return $this->operator['phone'];
        return $this->phone;
    }

    function getOperatorPositionAttribute(){
        // return $this->operator['position'];
        return null;
    }

    function getBusinessVerifiedAtAttribute(){
        if(!isset($this->verification['business'])){
            return 'Not Verified';
        }

        try{
            $r = Carbon::createFromTimeString($this->verification['business']);

            return $r->day.' '.substr($r->monthName, 0, 3).' '.$r->year;
        }catch(Exception $e){
            DebugService::catch($e);
            return 'Unknown';
        }
    }

    function getEmailVerifiedAtAttribute(){
        if(!isset($this->verification['email'])){
            return 'Not Verified';
        }

        try{
            $r = Carbon::createFromTimeString($this->verification['email']);

            return $r->day.' '.substr($r->monthName, 0, 3).' '.$r->year;
        }catch(Exception $e){
            DebugService::catch($e);
            return 'Unknown';
        }
    }

    function getPhoneVerifiedAtAttribute(){
        if(!isset($this->verification['phone'])){
            return 'Not Verified';
        }

        try{
            $r = Carbon::createFromTimeString($this->verification['phone']);

            return $r->day.' '.substr($r->monthName, 0, 3).' '.$r->year;
        }catch(Exception $e){
            DebugService::catch($e);
            return 'Unknown';
        }
    }

    function getRegisteredAtAttribute(){
        try{
            $r = $this->created_at;

            return $r->day.' '.substr($r->monthName, 0, 3).' '.$r->year;
        }catch(Exception $e){
            DebugService::catch($e);
            return 'Unknown';
        }
    }

    // scopes
    function scopeEmailVerified($q){
        $q->where('verification->email', '<>', null);
    }

    function scopePhoneVerified($q){
        $q->where('verification->phone', '<>', null);
    }

    function scopeAccountVerified($q){
        $q->emailVerified()->phoneVerified();
    }

    function scopeApproved($q){
        $q->whereStatus(self::STATUS_APPROVED);
    }

    function scopeRejected($q){
        $q->whereStatus(self::STATUS_REJECTED);
    }

    function scopePending($q){
        $q->whereStatus(self::STATUS_PENDING);
    }

    function scopePostPay($q){
        $q->where('payments->post_pay', true);
    }

    function scopePrePay($q){
        $q->where('payments->post_pay', '<>', true);
    }

    // helpers
    function isApproved(){
        return $this->status == self::STATUS_APPROVED;
    }

    function isRejected(){
        return $this->status == self::STATUS_REJECTED;
    }

    function isPending(){
        return $this->status == self::STATUS_PENDING;
    }

    function isPostPay(){
        return isset($this->payments['post_pay']) && $this->payments['post_pay'];
    }

    function isPrePay(){
        return !$this->isPostPay();
    }

    function hasEmailVerified(){
        return isset($this->verification['email']);
    }

    function hasPhoneVerified(){
        return isset($this->verification['phone']);
    }

    function hasAccountVerified(){
        return $this->hasEmailVerified() && $this->hasPhoneVerified();
    }
}
