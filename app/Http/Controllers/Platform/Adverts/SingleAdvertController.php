<?php

namespace App\Http\Controllers\Platform\Adverts;

use App\Http\Controllers\Controller;
use App\Helpers\ResultSet;
use App\Models\Advert;
use App\Services\DebugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SingleAdvertController extends Controller {
    function __invoke($advert_id){
        $advert = $this->user()
            ->adverts()
            ->whereId($advert_id)
            ->with('category', 'bookings', 'bookings.screen', 'bookings.package')
            ->first();

        return $this->view('web.ads.single', [
            'advert' => $advert
        ]);
    }

    function edit($advert_id){
        $advert = $this->user()
            ->adverts()
            ->whereId($advert_id)
            ->with('category', 'bookings', 'bookings.screen', 'bookings.package')
            ->first();

        return $this->view('web.ads.single', [
            'advert' => $advert
        ]);
    }

    function delete($advert_id){
        $advert = $this->user()
            ->adverts()
            ->whereId($advert_id)
            ->first();

        if($advert == null){
            return back()->withErrors([
                'status' => 'The advert does not exist or has been deleted from the system'
            ]);
        }

        DB::beginTransaction();

        try{
            if(!($advert->bookings()->delete() && $advert->invoice()->delete() && $advert->delete())){
                DB::rollback();
                return back()->withErrors([
                    'status' => 'Unable to delete the ad from the system. Please try again'
                ]);
            }

            DB::commit();
            return redirect()->route('platform.ads.all')->with([
                'status' => 'The advert has been deleted from the system'
            ]);
        }catch(Exception $e){
            DebugService::catch($e);
            DB::rollback();

            return back()->withErrors([
                'status' => 'Server error. Unable to delete the ad from the system'
            ]);
        }
    }
}
