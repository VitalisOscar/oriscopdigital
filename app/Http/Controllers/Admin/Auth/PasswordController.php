<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Rules\CorrectPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    function change(Request $request){

        if($request->isMethod('GET')){
            return $this->view('admin.staff.password');
        }

        $staff = $this->user();

        $validator = Validator::make($request->post(), [
            'password' => ['required', new CorrectPassword($staff)],
            'new_password' => ['required'],
            'confirm_password' => ['required', 'same:new_password']
        ],[
            'confirm_password.same' => 'Passwords do not match!'
        ]);

        if($validator->fails()){
            $validator->errors()->add('status', 'Please correct the highlighted errors on the form');
            return back()->withInput()->withErrors($validator->errors());
        }

        // Change password
        $staff->password = Hash::make($request->post('new_password'));

        // save
        if($staff->save()){
            return back()->with(['status' => 'Your new password has been set successfully']);
        }

        return back()->withInput()->withErrors(['status' => 'Something went wrong. Please try again']);
    }
}
