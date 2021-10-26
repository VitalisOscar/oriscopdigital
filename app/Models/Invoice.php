<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public $timestamps = false;

    const STATUS_PAID = 'paid';
    const STATUS_PENDING = 'pending';
    const STATUS_OVERDUE = 'overdue';

    protected $fillable = [
        'advert_id', 'tax', 'amount', 'due_date'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'due_date' => 'datetime',
        'tax' => 'array',
    ];

    function advert(){
        return $this->belongsTo(Advert::class);
    }

    function payments(){
        return $this->hasMany(Payment::class);
    }

    function successful_payment(){
        return $this->hasOne(Payment::class)->successful();
    }

    function pending_payment(){
        return $this->hasOne(Payment::class)->pending();
    }

    function payment(){
        return $this->hasOne(Payment::class)->successful();
    }

    // attributes
    function getNumberAttribute(){
        return $this->id;
    }

    function getStatusAttribute(){
        if($this->successful_payment != null){
            return self::STATUS_PAID;
        }else if(Carbon::now()->isAfter($this->due_date)){
            return self::STATUS_OVERDUE;
        }else{
            return self::STATUS_PENDING;
        }
    }

    function getTaxRateAttribute(){
        return $this->tax['rate'];
    }

    function getTaxValAttribute(){
        return $this->tax['amount'];
    }

    function getFmtSubTotalAttribute(){
        return 'KSh '.number_format($this->amount);
    }

    function getTotalAttribute(){
        return $this->amount + $this->tax_val;
    }

    function getFmtTotalAttribute(){
        return 'KSh '.number_format($this->total);
    }

    function getFmtTaxAttribute(){
        return 'KSh '.number_format($this->tax_val);
    }

    function getFmtTaxRateAttribute(){
        return $this->tax_rate.'% VAT';
    }

    function getFmtDueDateAttribute(){
        $d = $this->due_date;

        return $d->format('d').' '.substr($d->monthName, 0, 3).' '.$d->year;
    }

    function getFmtDateAttribute(){
        $d = $this->created_at;

        return $d->format('d').' '.substr($d->monthName, 0, 3).' '.$d->year;
    }


    // scopes
    function scopeHighest($q){
        $q->orderBy('amount', 'desc');
    }

    function scopeLowest($q){
        $q->orderBy('amount', 'asc');
    }

    function scopePaid($q){
        $q->whereHas('payments', function($q1){
            $q1->whereStatus(Payment::STATUS_SUCCESS);
        });
    }

    function scopeUnPaid($q){
        $q->whereDoesntHave('payments', function($q1){
            $q1->whereStatus(Payment::STATUS_SUCCESS);
        });
    }

    function scopePending($q){
        $q->whereDate('due_date', '>=', Carbon::today()->format('Y-m-d'));
    }

    function scopeOverDue($q){
        $q->whereDate('due_date', '<', Carbon::today()->format('Y-m-d'));
    }

    function scopePostPay($q){
        $q->whereHas('advert', function($q1){
            $q1->whereHas('user', function($q2){
                $q2->postPay();
            });
        });
    }

    function scopePrePay($q){
        $q->whereHas('advert', function($q1){
            $q1->whereHas('user', function($q2){
                $q2->prePay();
            });
        });
    }

    function scopeBetween($q, $from, $to){
        if($from > $to){
            $v = $from;
            $from = $to;
            $to = $v;
        }

        $q->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);
    }

    // helpers

    function hasPendingPayment(){
        return $this->pending_payment != null;
    }

    function isPaid()
    {
        return $this->status == self::STATUS_PAID;
    }

    function isUnpaid()
    {
        return !$this->isPaid();
    }

    function isOverDue()
    {
        return $this->status == self::STATUS_OVERDUE;
    }

    function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    function isPostPay(){

    }
}
