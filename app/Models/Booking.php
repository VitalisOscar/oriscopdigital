<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = [
        'advert_id', 'screen_id', 'package_id', 'dates', 'info', 'price'
    ];

    protected $with = [
        'screen', 'package'
    ];

    public $casts = [
        'dates' => 'array',
        'info' => 'array',
    ];

    function advert(){
        return $this->belongsTo(Advert::class);
    }

    function screen(){
        return $this->belongsTo(Screen::class);
    }

    function package(){
        return $this->belongsTo(Package::class);
    }


    function getFmtPriceAttribute(){
        return 'KSh '.number_format($this->price);
    }

    function getTotalDatesAttribute(){
        return $this->getAttribute('dates')['total'] ?? 0;
    }

    function getAllDatesAttribute(){
        return $this->getAttribute('dates')['all'] ?? [];
    }

}
