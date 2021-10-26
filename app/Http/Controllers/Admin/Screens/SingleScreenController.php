<?php

namespace App\Http\Controllers\Admin\Screens;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Screen;
use App\Models\ScreenPackage;
use App\Models\ScreenPrice;
use App\Models\StaffLog;
use App\Services\DebugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SingleScreenController extends Controller
{
    function getSCreen(Request $request, $id){
        $screen = Screen::where('id', $id)->first();

        if($screen == null){
            return redirect()->route('admin.screens.all')
                ->with([
                    'status' => 'The screen has been deleted or does not exist'
                ]);
        }

        $priced = $screen->packages;
        $unpriced = Package::whereDoesntHave('screens', function($s) use($screen){
            $s->where('screens.id', $screen->id);
        })
        ->get();

        return $this->view('admin.screens.single', [
            'priced_packages' => $priced,
            'unpriced_packages' => $unpriced,
            'screen' => $screen
        ]);
    }

    function pricing(Request $request, $id){
        // Validate
        $validator = Validator::make($request->post(), [
            'prices' => ['required', 'array'],
            'prices.*' => ['array'],
            'prices.*.package_id' => ['required', 'exists:packages,id'],
            'prices.*.price' => ['nullable', 'numeric', 'min:0']
        ], [
            'prices.required' => 'Please submit the different prices for the package',
            'prices.array' => 'Please submit the different prices for the package',
            'prices.*.array' => 'Please submit the different prices for the package',
            'prices.*.package_id.required' => 'Use the available form to submit the pricing data',
            'prices.*.package_id.exists' => 'Use the available form to submit the pricing data',
            'prices.*.price.numeric' => 'All prices should be valid positive values',
            'prices.*.price.min' => 'All prices should be valid positive values',
        ]);

        if($validator->fails()){
            return back()->withInput()->withErrors(['status' => $validator->errors()->first()]);
        }

        $screen = Screen::where('id', $id)
                ->first();

        DB::beginTransaction();

        // Loop through data, saving price info
        foreach($request->post('prices') as $new_price){
            if(!isset($new_price['package_id'], $new_price['price'])){
                continue;
            }

            $package_id = $new_price['package_id'];
            $package_price = $new_price['price'];

            // Check if price exists
            $sp = ScreenPackage::where([
                'screen_id' => $screen->id,
                'package_id' => $package_id
            ])->first();

            if($sp == null){
                // does not exist
                $sp = new ScreenPackage([
                    'screen_id' => $screen->id,
                    'package_id' => $package_id
                ]);
            }

            $sp->price = $package_price;

            try{
                $sp->save();
            }catch(Exception $e){
                DebugService::catch($e);
                DB::rollback();
                return back()->withInput()->withErrors(['status' => 'Something went wrong. Please try again']);
            }
        }

        DB::commit();
        return back()->withInput()->with(['status' => 'Pricing information for screen '.$screen->title.' has been captured and saved']);
    }

    function delete(Request $request, $id){
        $screen = Screen::where('id', $id)->first();

        if($screen == null){
            return $request->expectsJson() ?
                $this->json->error('Screen was not found in database') :
                back()->withInput()->withErrors(['status' => 'Screen was not found in database']);
        }

        DB::beginTransaction();
        if($screen->delete()){
            DB::commit();
            return $request->expectsJson() ?
                $this->json->success('The screen '.$screen->title.' has been deleted from screens') :
                redirect()->route('admin.screens.all')->withInput()->with(['status' => 'The screen '.$screen->title.' has been deleted from screens']);
        }

        DB::rollback();
        return $request->expectsJson() ?
            $this->json->error('Unable to delete screen, something went wrong. Please retry') :
            back()->withInput()->withErrors(['status' => 'Unable to delete screen, something went wrong. Please retry']);
    }

    function edit(Request $request, $id){
        $screen = Screen::where('id', $id)->first();

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

        $slug = \Illuminate\Support\Str::slug($request->post('title'));


        if($screen == null){
            return $request->expectsJson() ?
                $this->json->error('Screen was not found in database') :
                back()->withInput()->withErrors(['status' => 'Screen was not found in database']);
        }

        // Make change
        $screen->title = $request->post('title');
        $screen->online = $request->boolean('online');
        $screen->slug = $slug;

        DB::beginTransaction();

        if($screen->save()){
            DB::commit();
            return $request->expectsJson() ?
                $this->json->success('Screen '.$screen->title.' has been updated') :
                redirect()->route('admin.screens.single', $screen->id)->withInput()->with(['status' => 'Screen '.$screen->title.' has been updated']);
        }

        DB::rollback();
        return $request->expectsJson() ?
            $this->json->error('Unable to make change, something went wrong. Please retry') :
            back()->withInput()->withErrors(['status' => 'Unable to make change, something went wrong. Please retry']);

    }
}
