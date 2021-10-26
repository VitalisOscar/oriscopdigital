<?php

namespace App\Http\Controllers\Admin\Packages;

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

class SinglePackageController extends Controller
{
    function __invoke($id){
        $package = Package::where('id', $id)
            ->first();

        $priced = $package->screens;
        $unpriced = Screen::whereDoesntHave('packages', function($p) use($package){
            $p->where('packages.id', $package->id);
        })
        ->get();

        return $this->view('admin.packages.single', [
            'package' => $package,
            'priced_screens' => $priced,
            'unpriced_screens' => $unpriced,
            'total_screens' => Screen::count()
        ]);
    }

    function edit(Request $request, $id){
        $validator = Validator::make($request->post(), [
            'name' => ['required'],
            'type' => ['required', 'in:peak,off_peak'],
            'clients' => ['required', 'integer', 'min:1'],
            'loops' => ['required', 'integer', 'min:1'],
            'from' => ['required', 'integer', 'min:0', 'max:23'],
            'to' => ['required', 'integer', 'min:0', 'max:23'],
        ],[
            'category.in' => 'Select a valid category',
            'clients.min' => 'Minimum number of clients is 1',
            'loops.min' => 'Minimum number of loops is 1',
            'from.min' => 'Select a valid start time',
            'to.min' => 'Select a valid end time',
            'from.max' => 'Select a valid start time',
            'to.max' => 'Select a valid end time',
        ]);

        if($validator->fails()){
            return back()->withInput()->withErrors(['status' => $validator->errors()->first()]);
        }

        $package = Package::where('id', $id)
            ->first();

        $package->name = $request->post('name');
        $package->type = $request->post('type');
        $package->clients = $request->post('clients');
        $package->loops = $request->post('loops');
        $package->plays_from = $request->post('from');
        $package->plays_to = $request->post('to');

        // Staff log
        $staff = auth('staff')->user();

        $log = new StaffLog([
            'staff_id' => $staff->id,
            'activity' => "Updated package '".$package->name."'",
            'item' => StaffLog::ITEM_PACKAGE,
            'item_id' => $package->id
        ]);

        DB::beginTransaction();

        if($package->save() && $log->save()){
            DB::commit();
            return back()->withInput()->with(['status' => "The package ".$package->name." has been updated"]);
        }

        DB::rollback();
        return back()->withInput()->withErrors(['status' => 'Something went unexpectedly wrong']);
    }

    function pricing(Request $request, $id){
        // Validate
        $validator = Validator::make($request->post(), [
            'prices' => ['required', 'array'],
            'prices.*' => ['array'],
            'prices.*.screen_id' => ['required', 'exists:screens,id'],
            'prices.*.price' => ['nullable', 'numeric', 'min:0']
        ], [
            'prices.required' => 'Please submit the different prices for the package',
            'prices.array' => 'Please submit the different prices for the package',
            'prices.*.array' => 'Please submit the different prices for the package',
            'prices.*.screen_id.required' => 'Use the available form to submit the pricing data',
            'prices.*.screen_id.exists' => 'Use the available form to submit the pricing data',
            'prices.*.price.numeric' => 'All prices should be valid positive values',
            'prices.*.price.min' => 'All prices should be valid positive values',
        ]);

        if($validator->fails()){
            return back()->withInput()->withErrors(['status' => $validator->errors()->first()]);
        }

        $package = Package::where('id', $id)
                ->first();

        DB::beginTransaction();

        // Loop through data, saving price info
        foreach($request->post('prices') as $new_price){
            if(!isset($new_price['screen_id'], $new_price['price'])){
                continue;
            }

            $screen_id = $new_price['screen_id'];
            $screen_price = $new_price['price'];

            // Check if price exists
            $sp = ScreenPackage::where([
                'screen_id' => $screen_id,
                'package_id' => $id
            ])->first();

            if($sp == null){
                // does not exist
                $sp = new ScreenPackage([
                    'screen_id' => $screen_id,
                    'package_id' => $id
                ]);
            }

            $sp->price = $screen_price;

            try{
                $sp->save();
            }catch(Exception $e){
                DebugService::catch($e);
                DB::rollback();
                return back()->withInput()->withErrors(['status' => 'Something went wrong. Please try again']);
            }
        }

        DB::commit();
        return back()->withInput()->with(['status' => 'Pricing information for package '.$package->name.' has been captured and saved']);
    }
}
