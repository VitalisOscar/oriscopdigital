<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenPackage extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'screen_packages';

    public $fillable = ['screen_id', 'package_id', 'type', 'price'];
}
