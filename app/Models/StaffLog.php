<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffLog extends Model
{
    use HasFactory;

    protected $table = 'staff_logs';

    const ITEM_ADVERT = 'advert';
    const ITEM_CATEGORY = 'category';
    const ITEM_USER = 'user';
    const ITEM_AGENT = 'agent';
    const ITEM_STAFF = 'staff';
    const ITEM_INVOICE = 'invoice';
    const ITEM_PACKAGE = 'package';
    const ITEM_SCREEN = 'screen';

    const CATEGORIES = [
        'advert' => 'Adverts',
        'category' => 'Categories',
        'user' => 'Clients',
        'staff' => 'Staff ACcounts',
        'invoice' => 'Invoices',
        'package' => 'Packages',
        'screen' => 'Screens'
    ];

    const ACTIVITY_CREATED = 'Created';
    const ACTIVITY_MODIFIED = 'Modified';
    const ACTIVITY_DELETED = 'Deleted';

    public $timestamps = false;

    public $fillable = [
        'staff_id',
        'time',
        'activity',
        'item_type',
        'item_id'
    ];

    protected $casts = [
        'time' => 'datetime'
    ];

    function staff(){
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    function item(){
        return $this->morphTo('item');
    }
}
