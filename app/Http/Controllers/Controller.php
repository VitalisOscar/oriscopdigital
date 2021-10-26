<?php

namespace App\Http\Controllers;

use App\Helpers\CustomJsonResponse;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $json;

    function __construct(CustomJsonResponse $json){
        $this->json = $json;
    }

    /**
     * @return User
     */
    function user(){
        $request = request();

        $guard = 'platform';

        if($request->is('admin*')){
            $guard = 'staff';
        }

        return auth($guard)->user();
    }

     /**
     * Create a response for a view.
     */
    function view($view, $data = [], $status = 200, array $headers = []){
        $data['user'] = $this->user();

        $data['current_route'] = \Illuminate\Support\Facades\Route::current();
        $data['current_route_name'] = $data['current_route']->getName();

        return response()->view($view, $data, $status, $headers);
    }
}
