<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Exports\ExcelExport;
use App\Helpers\ResultSet;
use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Category;
use App\Repository\AdminAdvertRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdvertsController extends Controller
{
    function getAll(Request $request){
        $query = Advert::query();
        $request = request();

        // by client
        if($request->filled('client')){
            $query->whereHas('user', function ($u) use($request){
                $u->whereId($request->get('client'));
            });
        }

        // Status
        if($request->filled('status')){
            $s = $request->get('status');

            if($s == 'approved') $query->approved();
            else if($s == 'rejected') $query->rejected();
            else if($s == 'pending') $query->pending();
        }

        // Category
        if($request->filled('category')) $query->inCategory($request->get('category'));

        // Ordering
        $order = $request->get('order', 'recent');

        if(!in_array($order, ['recent', 'oldest'])) $order = 'recent';

        if($order == 'recent') $query->latest();
        else $query->oldest();


        $query->with('category', 'user');

        return $this->view('admin.adverts.list', [
            'result' => new ResultSet($query, 15),
            'category' => $request->filled('category') ? Category::where('id', $request->get('category'))->first() : null
        ]);
    }

    function export(AdminAdvertRepository $repository){
        $filename = 'adverts_'.str_replace('-', '_', Carbon::now()->format('Y-m-d')).'.csv';

        return Excel::download(new ExcelExport($repository->getQuery(null)->with('slots'), Advert::exportHeaders()), $filename);
    }

    function getSingle($id){
        $ad = Advert::whereId($id)
            ->with('category', 'bookings', 'invoice', 'user')
            ->first();

        return $this->view('admin.adverts.single', [
            'advert' => $ad
        ]);
    }
}
