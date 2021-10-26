<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;

class DebugService{
    static function catch(Exception $e){
        Storage::put('debug/'.time(), $e);
    }
}
