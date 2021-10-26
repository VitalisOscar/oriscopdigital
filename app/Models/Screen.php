<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Screen extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    public $fillable = ['name', 'online', 'slug'];

    function bookings(){
        return $this->hasMany(Booking::class);
    }

    function packages(){
        return $this->belongsToMany(Package::class, 'screen_packages')->withPivot('price');
    }

    function scopeOnline($q){
        $q->whereOnline(true);
    }

    function scopeOffline($q){
        $q->whereNot('online', true);
    }
}
