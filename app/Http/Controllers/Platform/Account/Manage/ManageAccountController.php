<?php

namespace App\Http\Controllers\Platform\Account\Manage;

use App\Http\Controllers\Controller;
use App\Helpers\ResultSet;
use App\Models\Advert;
use Illuminate\Http\Request;

class ManageAccountController extends Controller {
    function __invoke(Request $request){
        return $this->view('web.user.account');
    }
}
