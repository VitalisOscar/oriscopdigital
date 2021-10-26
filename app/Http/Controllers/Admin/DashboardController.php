<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Category;
use App\Models\Screen;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function __invoke(Request $request)
    {
        return $this->view('admin.dashboard', [
            'recent_adverts' => Advert::latest()->limit(5)->get(),
            'pending_clients' => User::pending()->latest()->limit(8)->get(),
            'totals' => [
                'clients' => User::count(),
                'adverts' => Advert::count(),
                'categories' => Category::count(),
                'scheduled_adverts' => Advert::canBeAired()->scheduled(today())->count()
            ]
        ]);
    }
}
