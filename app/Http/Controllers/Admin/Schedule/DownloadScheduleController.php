<?php

namespace App\Http\Controllers\Admin\Schedule;

use App\Helpers\ResultSet;
use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Screen;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\File as FileFile;
use ZipArchive;

class DownloadScheduleController extends Controller
{
    function __invoke(Request $request)
    {
        $screen = Screen::where('id', $request->get('screen'))->first();
        $package = Package::where('id', $request->get('package'))->first();
        $date = $request->get('date');

        //
        if($screen == null || $package == null || $date == null){
            return back()->withErrors([
                'status' => 'Please select a screen, package and date to download booked ads',
            ]);
        }

        $adverts = Advert::approved()
            // Ad has a scheduled slot
            ->scheduled(Carbon::createFromFormat('Y-m-d', $date))
            ->canBeAired() // Ad meets airing conditions
            ->with(['user'])
            ->get();

        if(count($adverts) == 0){
            return back()->withErrors([
                'status' => 'There are no slots booked on '.config('app.name').' for the specified date, screen and package',
            ]);
        }

        $schedule = \Illuminate\Support\Str::slug(
            $date.' '.
            $package->name.' '.
            $screen->name
        );

        $zip = new ZipArchive();
        $zipname = 'schedules/'.$schedule.'.zip';

        $zipname = public_path('storage/'.$zipname);

        DB::beginTransaction();

        if($zip->open($zipname, ZipArchive::CREATE)){
            foreach($adverts as $ad){
                $path = str_replace('//', '/', public_path('storage/'.$ad->file_path));

                if(file_exists($path)){
                    $file = new FileFile(public_path('storage/'.$ad->file_path));

                    $name = \Illuminate\Support\Str::slug($ad->user->name.'__'.$ad->description).'.'.$file->getExtension();;
                    $zip->addFile($path, $schedule.'/'.strtolower($name));
                }
            }
        }

        if($zip->close()){
            return response()->download($zipname);
        }

        return back()->withErrors([
            'status' => 'Unable to generate file for download. Please try again',
        ]);
    }

    // function single(Request $request){
    //     $slot_id = $request->get('slot');

    //     $slot = Slot::where('id', $slot_id)->with('advert')->first();
    //     $ad = $slot != null ? $slot->advert:null;

    //     // // Ad must be approved
    //     // $ad = Advert::where('status', Advert::STATUS_APPROVED)
    //     //     // Must have a scheduled slot
    //     //     ->whereHas('scheduled_slot')
    //     //     // Invoice has been  paid for or client is post pay
    //     //     ->where(function($q){
    //     //         $q->whereHas('invoice', function($q){
    //     //                 $q->where('status', Invoice::STATUS_PAID);
    //     //             })
    //     //             ->orWhereHas('user', function($q){
    //     //                 $q->where('payment->post_pay', true);
    //     //             });
    //     //     })
    //     //     ->where('id', $id)
    //     //     ->with(['user', 'scheduled_slot'])
    //     //     ->first();

    //     if($ad == null || $slot == null){
    //         return back()->withErrors([
    //             'status' => 'Advert not found, or not scheduled for playing on selected date and screen',
    //         ]);
    //     }

    //     $path = str_replace('//', '/', public_path('storage/'.$ad->content['media_path']));

    //     if(file_exists($path)){
    //         $file = new FileFile(public_path('storage/'.$ad->content['media_path']));

    //         $name = preg_replace("/ +/", "-",$ad->user->business['name'].'__'.$ad->description).'.'.$file->getExtension();;
    //         $name = strtolower($name);

    //         // Mark slot as downloaded
    //         $status = $slot->status;
    //         $status['downloaded'] = true;
    //         $slot->status = $status;

    //         if(!$slot->save()){
    //             return back()->withErrors([
    //                 'status' => 'Something went wrong. Please try again',
    //             ]);
    //             DB::rollback();
    //         }

    //         // Download media
    //         return response()->download(public_path('storage/'.$ad->content['media_path']), $name);
    //     }

    //     return back()->withErrors([
    //         'status' => 'The ad does not have any media content to download',
    //     ]);
    // }
}
