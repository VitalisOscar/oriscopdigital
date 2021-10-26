<?php

namespace App\Traits;

use App\Models\Advert;
use App\Models\Booking;

trait HandlesBookings{
    function allBookingsAvailable(Advert $advert){
        // $bookings = $advert->bookings;
        // $packages = $advert->packages;

        // foreach($packages as $package){

        // }
        return true;

    }
}
