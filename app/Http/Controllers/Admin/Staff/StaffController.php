<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    function getAll(){
        $staff = Staff::all();

        return $this->view('admin.staff.list', ['staff' => $staff]);
    }

    function add(Request $request){
        if($request->isMethod('GET')){
            return $this->view('admin.staff.add');
        }

        $validator = Validator::make($request->post(), [
            'name' => ['required'],
            'username' => ['required', 'unique:staff,username'],
            'password' => ['required'],
            'role' => ['required', 'in:'.Staff::ROLE_ADMIN.','.Staff::ROLE_STAFF]
        ], [
            'username.unique' => 'The username is already associated with another account',
            'role.in' => 'The specified role is invalid'
        ]);

        if($validator->fails()){
            $validator->errors()->add('status', 'Please correct the highlighted errors on the form');
            return back()->withInput()->withErrors($validator->errors());
        }

        $staff = new Staff([
            'name' => $request->post('name'),
            'username' => $request->post('username'),
            'password' => Hash::make($request->post('password')),
            'role' => $request->post('role')
        ]);

        if($staff->save()){
            return redirect()->route('admin.staff.all')
                ->with(['status' => 'Staff account for '.$staff->name.' has been added to the system']);
        }

        return back()->withInput()->withErrors([
            'status' => 'Unable to create account. Please try again'
        ]);
    }
}
