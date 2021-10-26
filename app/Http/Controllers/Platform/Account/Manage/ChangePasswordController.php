<?php

namespace App\Http\Controllers\Platform\Account\Manage;

use App\Http\Controllers\Controller;
use App\Rules\CorrectPassword;
use App\Services\DebugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller {
    function __invoke(Request $request){
        // current user
        $user = $this->user();

        $validator = validator($request->post(), [
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:new_password'],
            'password' => ['required', new CorrectPassword($user)],
        ],[
            'new_password.regex' => 'Password should contain at least 8 characters with at least one letter',
            'confirm_password.same' => 'Passwords do not match!'
        ]);

        if($validator->fails()){
            return back()
                ->withInput()
                ->withErrors($validator->errors());
        }

        try{
            // Change password
            $user->password = Hash::make($request->post('new_password'));

            if($user->save()){
                return back()
                    ->with(['status' => 'New password has been saved, next time you log in, use it']);
            }
        }catch(Exception $e){
            DebugService::catch($e);
        }

        return back()
            ->withInput()
            ->withErrors(['status' => 'Something went wrong. Password cannot be updated']);
    }
}
