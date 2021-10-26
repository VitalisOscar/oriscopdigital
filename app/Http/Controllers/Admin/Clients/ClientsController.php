<?php

namespace App\Http\Controllers\Admin\Clients;

use App\Helpers\ResultSet;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    function getAll(Request $request){
        $query = User::query();

        // search
        if($request->filled('search')){
            $search = $request->get('search');
            $query->where(function($q) use($search){
                $q->where('business->phone', 'like', '%'.$search.'%')
                    ->orWhere('business->email', 'like', '%'.$search.'%')
                    ->orWhere('business->name', 'like', '%'.$search.'%');
            });
        }

        // Verification Status
        if($request->filled('status')){
            $status = $request->get('status');

            if($status == 'verified') $query->approved();
            else if($status == 'pending') $query->pending();
            else if($status == 'rejected') $query->rejected();
        }

        // Sort
        $order = intval($request->get('order'));
        if($order == 1) $query->oldest();
        else if($order == 2) $query->orderBy('name', 'asc');
        else if($order == 3) $query->orderBy('name', 'desc');
        else $query->latest();

        $query->withCount('adverts');

        return $this->view('admin.clients.list', [
            'result' => new ResultSet($query, 20)
        ]);
    }
}
