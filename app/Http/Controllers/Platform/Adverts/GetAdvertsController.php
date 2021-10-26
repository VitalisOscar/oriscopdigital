<?php

namespace App\Http\Controllers\Platform\Adverts;

use App\Http\Controllers\Controller;
use App\Helpers\ResultSet;
use App\Models\Advert;
use App\Models\Booking;
use Illuminate\Http\Request;

class GetAdvertsController extends Controller {
    function __invoke(Request $request){
        $query = $this->user()
            ->adverts()
            ->whereHas('category')
            ->withCount('bookings')
            ->with('category');
            // ->addSelect([
            //     'slots' => Booking::where([
            //         'advert_id' => 'adverts.id'
            //     ])
            //     ->selectRaw(
            //         "sum(json_extract(dates,'$.total'))"
            //     )
            // ]);

        // Status
        if($request->get('status') == 'approved') $query->approved();
        elseif($request->get('status') == 'rejected') $query->rejected();
        elseif($request->get('status') == 'pending') $query->pending();

        // Media
        if($request->filled('media')) $query->hasMedia($request->get('media'));

        // Category
        if($request->filled('category')) $query->inCategory($request->get('category'));

        // Order
        if($request->get('order') == 0){
            $query->oldest();
        }else{
            $query->latest();
        }

        // Fetch the result
        $result = new ResultSet($query, 20);

        return $this->view('web.ads.all', [
            'result' => $result,
        ]);
    }
}
