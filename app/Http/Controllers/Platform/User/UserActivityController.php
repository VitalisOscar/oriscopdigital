<?php

namespace App\Http\Controllers\Platform\User;

use App\Http\Controllers\Controller;

class UserActivityController extends Controller
{
    public function home()
    {
        $user = $this->user();

        return $this->view('web.user.dashboard', [
            'recent_ads' => $user->adverts()->latest()->limit(5)->get(),
            'summary' => [
                'pending' => $user->adverts()->pending()->count(),
                'approved' => $user->adverts()->approved()->count(),
                'rejected' => $user->adverts()->rejected()->count(),
            ],
            'notifications' => []
        ]);
    }
}
