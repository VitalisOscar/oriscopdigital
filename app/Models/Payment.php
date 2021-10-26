<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const STATUS_FAILED = 'failed';
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';

    const METHOD_PESAPAL = 'PesaPal';
    const METHOD_MPESA = 'M-Pesa';
    const METHOD_CHEQUE = 'Cheque';

    const OTHER_METHODS = [
        'M-Pesa', 'Cheque'
    ];

    public $fillable = [
        'invoice_id', 'amount', 'method', 'status', 'generated', 'code'
    ];

    function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    function scopeSuccessful($q) {
        $q->whereStatus(self::STATUS_SUCCESS);
    }

    function scopePending($q) {
        $q->whereStatus(self::STATUS_PENDING);
    }

    function scopeFailed($q) {
        $q->whereStatus(self::STATUS_FAILED);
    }
}
