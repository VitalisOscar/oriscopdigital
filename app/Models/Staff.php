<?php

namespace App\Models;

use App\Services\DebugService;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use HasFactory;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_STAFF = 'staff';

    public $timestamps = false;

    protected $table = "staff";

    protected $fillable = [
        'username', 'name', 'password', 'role'
    ];

    protected $casts = [
        'added_at' => 'datetime'
    ];

    function isAdmin(){
        return $this->role == self::ROLE_ADMIN;
    }

    function getFmtDateAttribute(){
        try{
            $r = $this->added_at;

            return $r->day.' '.substr($r->monthName, 0, 3).' '.$r->year;
        }catch(Exception $e){
            DebugService::catch($e);
            return 'Unknown';
        }
    }
}
