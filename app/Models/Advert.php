<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    use HasFactory;

    const STATUS_APPROVED = 'Approved';
    const STATUS_REJECTED = 'Rejected';
    const STATUS_PENDING = 'Pending';

    const MEDIA_DIR = 'adverts';

    public $fillable = [
        'user_id', 'category_id', 'description', 'media', 'status'
    ];

    public $casts = [
        'media' => 'array',
        'created_at' => 'datetime',
    ];

    protected $hidden = ['media'];

    protected $appends = ['media_type', 'media_path', 'category_name'];

    protected $with = ['category'];

    protected static function booted()
    {
        static::addGlobalScope('category', function (Builder $builder) {
            $builder->whereHas('category', function($c){
                $c->withTrashed();
            });
        });
    }

    function invoice(){
        return $this->hasOne(Invoice::class);
    }

    function category(){
        return $this->belongsTo(Category::class)->withTrashed();
    }

    function user(){
        return $this->belongsTo(User::class);
    }

    function bookings(){
        return $this->hasMany(Booking::class);
    }

    // Attributes
    function getMediaPathAttribute(){
        return asset('storage/'.$this->media['path']);
    }

    function getFilePathAttribute(){
        return $this->media['path'];
    }

    function getMediaTypeAttribute(){
        return $this->media['type'];
    }

    function getCategoryNameAttribute(){
        return $this->category->name;
    }

    function getFmtDateAttribute(){
        $d = $this->created_at;

        return $d->format('d').' '.substr($d->monthName, 0, 3).' '.$d->year;
    }

    // scopes
    function scopeCanBeAired($q){
        // Has to be paid, or client to be in post pay
        $q->where(function($q1){
            $q1->paidFor()
            ->orWhere(function($q2){
                $q2->whereHas('user', function($u){
                    $u->postPay();
                });
            });
        });
    }

    function scopeScheduled($q, $on){
        // Has booking on date
        $q->whereHas('bookings', function($b) use($on){
            $on = $on->format('Y-m-d');

            $b->where(function($q1) use($on){
                $q1->where('dates->from', '<=', $on)
                    ->where('dates->to', '>=', $on);
            })
            ->orWhere(function($q2) use($on){
                $q2->whereJsonContains('dates->all', $on);
            });
        });
    }

    function scopePaidFor($q){
        $q->whereHas('invoice', function($i){
            $i->paid();
        });
    }

    function scopeHasImage($q){
        $q->where('media->type', 'image');
    }

    function scopeHasVideo($q){
        $q->where('media->type', 'video');
    }

    function scopeHasMedia($q, $media){
        if(!is_array($media)) $media = array($media);
        $q->whereIn('media->type', $media);
    }

    function scopeInCategory($q, $category){
        $q->where('category_id', $category);
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

    function hasImageMedia(){
        return $this->media_type == 'image';
    }

    function hasVideoMedia(){
        return $this->media_type == 'video';
    }

    function isPaidFor(){
        return $this->invoice()
            ->paid()
            ->first() != null;
    }
}
