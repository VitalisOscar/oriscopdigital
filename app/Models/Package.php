<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    const TYPE_PEAK = 'Peak';
    const TYPE_OFF_PEAK = 'Off Peak';

    public $timestamps = false;

    public $fillable = [
        'name', 'from', 'to', 'loops', 'clients', 'type'
    ];

    protected $appends = ['summary'];

    function bookings(){
        return $this->hasMany(Booking::class);
    }

    function screens(){
        return $this->belongsToMany(Screen::class, 'screen_packages')->withPivot('price');
    }

    function getFmtFromAttribute(){
        if($this->from == 12) return '12:00 Noon';

        return ($this->from < 12 ? $this->from.':00 AM' : (($this->from - 12).':00 PM'));
    }

    function getFmtToAttribute(){
        if($this->to == 12) return '12:00 Noon';

        return ($this->to < 12 ? $this->to.':00 AM' : (($this->to - 12).':00 PM'));
    }

    function getSummaryAttribute(){
        return $this->name.' ('.$this->fmt_from.' to '.$this->fmt_to.')';
    }
}
