<?php

namespace App\Http\Controllers\Admin\Schedule;

use App\Helpers\ResultSet;
use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Package;
use App\Models\Payment;
use App\Models\PlaybackComment;
use App\Models\Screen;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    function __invoke(Request $request)
    {
        // if($re)
        // if(!($request->filled('screen') && $request->filled('package') && $request->filled('date'))){
        //     return response()->view('admin.schedule.schedule', [
        //         'adverts' => [],
        //         'fetched' => false
        //     ]);
        // }

        $screen = Screen::where('id', $request->get('screen'))->first();
        $package = Package::where('id', $request->get('package'))->first();
        $date = Carbon::hasFormat($request->get('date'), 'Y-m-d') ?
            Carbon::createFromFormat('Y-m-d', $request->get('date')) :
            today();

        // Ad must be approved
        $query = Advert::approved()
            // Ad has a scheduled slot
            ->scheduled($date)
            ->canBeAired() // Ad meets airing conditions
            ->with(['user']);

        // $playback_comment = PlaybackComment::where([
        //         'screen_id' => $request->post('screen'),
        //         'package_id' => $request->post('package'),
        //         'play_date' => $date,
        //     ])->first();

        return $this->view('admin.schedule.schedule', [
            'adverts' => $query->get(),
            'screen' => $screen,
            'package' => $package,
            'date' => $date->format('Y-m-d'),
            'fmt_date' => $date->format('d').' '.substr($date->monthName, 0, 3).' '.$date->year,
            // 'playback_comment' => $playback_comment
        ]);
    }
}
