<?php

namespace App\Traits;

use App\Models\Advert;
use App\Models\Booking;
use App\Models\ScreenPackage;
use App\Models\User;
use App\Services\DebugService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

trait CreatesAdverts{
    use HandlesBookings;

    /**
     * Create a new ad
     * @param array $data Advert info
     * @param UploadedFile $media Advert media file
     * @param User $user User to own the ad
     * @return true|string
     */
    function createNew($data, $media, $user){
        $media_type = explode('/', $media->getMimeType())[0];

        // e.g adverts/video/2021/09/22
        $path = Advert::MEDIA_DIR
            .'/'.$media_type
            .'/'.str_replace('-', '/', Carbon::today()->format('Y-m-d'));

        DB::beginTransaction();

        try{
            $advert = new Advert([
                'user_id' => $user->id,
                'category_id' => $data['category_id'],
                'description' => $data['description'],
                'media' => [
                    'type' => $media_type,
                    'path' => $media->store($path, 'public')
                ],
                'status' => Advert::STATUS_PENDING
            ]);

            if(!$advert->save()){
                return 'Something went wrong. Please try again';
            }

            // Booked slots
            $bookings = $data['slots'];

            foreach($bookings as $b){
                // Dates
                $from = null;
                $to = null;
                $all = null;

                $dates = $b['play_date'];
                // e.g from 2021-04-11 to 2021-04-17
                // if(preg_match("/([0-9]){4}\-([0-9]){2}\-([0-9]){2} +to +([0-9]){4}\-([0-9]){2}\-([0-9]){2}/", $dates)){
                //     $dates = explode('to', preg_replace(' +', '', $dates));
                //     $from = $dates[0];
                //     $to = $dates[1];
                // }else{
                //     $all = explode(',', preg_replace(['/, +/', '/ +,/'], ',', $dates));
                // }

                $price = ScreenPackage::where('package_id', $b['package'])
                    ->where('screen_id', $b['screen_id'])
                    ->first()
                    ->price * count($dates);

                $booking = $advert->bookings()->create([
                    'screen_id' => $b['screen_id'],
                    'package_id' => $b['package'],
                    'dates' => [
                        'total' => count($dates),
                        'from' => $from,
                        'to' => $to,
                        'all' => $dates
                    ],
                    'info' => [],
                    'price' => $price
                ]);

                if(!$booking){
                    DB::rollback();
                    return 'Something went wrong. Please try again';
                }

                if(!$this->allBookingsAvailable($advert)){
                    DB::rollback();
                    return 'All slots are no longer available';
                }

                DB::commit();
                return true;
            }

        }catch(Exception $e){
            DB::rollback();
            DebugService::catch($e);
            return $e->getMessage().'Sorry. A server error was encountered. Please try again in a few moments';
        }
    }


}
