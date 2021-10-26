<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SingleStaffController extends Controller
{

    function get($username){
        $staff = Staff::where('username', $username)->first();

        if($staff == null){
            return $this->view('admin.error.staff_not_exist');
        }

        return $this->view('admin.staff.single', ['staff' => $staff]);
    }

    function resetPassword(Request $request, $username){
        $validator = Validator::make($request->post(), [
            'password' => ['required']
        ]);

        if($validator->fails()){
            return back()->withInput()->withErrors(['status' => 'Please try again and provide the new password for the account']);
        }

        $staff = Staff::where('username', $username)->first();

        if($staff == null){
            return response()->view('admin.error.staff_not_exist');
        }

        $staff->password = Hash::make($request->post('password'));

        DB::beginTransaction();

        // save
        if($staff->save()){
            DB::commit();
            return redirect()->route('admin.staff.single', $staff->username)->with([
                'status' => 'New password can now be used to log in the account'
            ]);
        }

        DB::rollback();
        return back()->withInput()->withErrors(['status' => 'Unable to reset staff password. Please try again']);
    }


    function edit(Request $request, $username){
        $staff = Staff::where('username', $username)->first();

        if($staff == null){
            return view('admin.error.staff_not_exist');
        }

        $validator = Validator::make($request->post(), [
            'name' => ['required'],
            'username' => ['required', Rule::unique('staff', 'username')->ignore($staff->id)],
            'role' => ['required', 'in:'.Staff::ROLE_ADMIN.','.Staff::ROLE_STAFF]
        ], [
            'username.unique' => 'The username is already associated with another account',
            'role.in' => 'The specified role is invalid'
        ]);

        if($validator->fails()){
            $validator->errors()->add('status','You need to correct the errors highlighted in the form');
            return back()->withInput()->withErrors($validator->errors());
        }

        // If updating own account
        // If role is being updated to regular account
        // yet there is only one admin account
        $admin = auth('staff')->user();

        if($staff->id == $admin->id &&
            $request->role == Staff::ROLE_STAFF &&
            Staff::where('role', Staff::ROLE_ADMIN)->count() == 1
        ){
            return back()->withInput()->withErrors(['status'=>"You need to assign administrative roles to another account before making your account regular"]);
        }

        // Make changes
        $staff->username = $request->post('username');
        $staff->name = $request->post('name');
        $staff->role = $request->post('role');

        // save
        if($staff->save()){
            return redirect()->route('admin.staff.single', $staff->username)->with([
                'status' => 'All changes have been saved to database'
            ]);
        }

        return back()->withInput()->withErrors(['status' => 'Unable to make changes. Something went wrong']);
    }

    function delete(Request $request, $username){
        $staff = Staff::where('username', $username)->first();

        if($staff == null){
            return view('admin.error.staff_not_exist');
        }

        $admin = auth('staff')->user();

        // Check if the admin is deleting own account, yet it's the only with admin privileges
        if($staff->id == $admin->id && Staff::where('role', Staff::ROLE_ADMIN)->count() == 1){
            return back()->withErrors(['status'=>'You need to assign administrative roles to another account before deleting this account']);
        }

        // delete
        if($staff->delete()){
            return redirect()->route('admin.staff.all')->with([
                'status' => 'Account for '.$staff->name.' has been deleted from system'
            ]);
        }

        return back()->withErrors(['status' => 'Unable to delete account. Something went wrong']);
    }
}
