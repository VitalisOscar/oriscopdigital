<?php

namespace App\Http\Controllers\Admin\Screens;

use App\Http\Controllers\Controller;
use App\Models\Screen;
use App\Models\StaffLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScreensController extends Controller
{
    function getAll(Request $request){
        $screens = Screen::all();

        return $this->view('admin.screens.list', [
            'screens' => $screens
        ]);
    }

    function add(Request $request){
        $validator = validator()->make($request->post(), [
            'name' => ['required'],
            // 'slug' => ['unique:screens,slug'],
        ],[
            'name.required' => 'Provide the screen title, e.g Kimathi Street',
            'slug.unique' => 'The screen '.$request->post('title').' already exists'
        ]);

        if($validator->fails()){
            return $request->expectsJson() ?
                $this->json->error($validator->errors()->first()) :
                back()->withInput()->withErrors(['status' => $validator->errors()->first()]);
        }

        $slug = \Illuminate\Support\Str::slug($request->post('name'));

        // Check if there is a soft deleted screen and restore it
        $screen = Screen::whereSlug($slug)->withTrashed()->first();

        if($screen != null){
            if($screen->trashed()){

                $screen->restore();

                return $request->expectsJson() ?
                    $this->json->success("The screen ".$screen->title." has been restored") :
                    back()->withInput()->with(['status' => "The screen ".$screen->title." has been restored"]);
            }

            return $request->expectsJson() ?
                $this->json->success("The screen ".$screen->title." already exists") :
                back()->withInput()->withErrors(['status' => "The screen ".$screen->title." already exists"]);
        }

        $screen = new Screen([
            'name' => $request->post('name'),
            'online' => $request->boolean('online'),
            'slug' => $slug,
        ]);

        DB::beginTransaction();

        try{
            $screen->save();

            DB::commit();

            return $request->expectsJson() ?
                $this->json->success("New screen ".$screen->title." has been saved") :
                back()->withInput()->with(['status' => "New screen ".$screen->title." has been saved"]);

        }catch(Exception $e){
            return $request->expectsJson() ?
                $this->json->error('Something went unexpectedly wrong') :
                back()->withInput()->withErrors(['status' => 'Something went unexpectedly wrong']);
        }
    }

}
