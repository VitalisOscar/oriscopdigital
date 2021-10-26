@extends('web.layouts.user_area')

@section('title', $advert != null ? ('Ad Overview - '.$advert->description):'Advert not found')

@section('section_heading', 'Advert Info')

@section('content')

@if($advert == null)
<div class="lead mb-3">
    The advert you are looking for does not exist
</div>

<a href="{{ route('platform.ads.all') }}" class="btn btn-primary btn-rounded">View All Ads</a>
@else


<div class="row">

    <div class="col-md-6 col-lg-6 pr-lg-5">
        <div class="info">
            @if($advert->isApproved())
                This ad has been approved.
                @if($advert->invoice->isUnpaid())
                <div class="mb-2">
                    Complete payment to have your content aired as booked
                </div>

                <form action="{{ route('platform.invoices.pay', $advert->invoice->number) }}" method="get" class="d-block mt-2">
                    <button class="btn btn-default btn-sm"><i class="ni ni-money-coins mr-1"></i>Complete Payment</button>
                </form>
                @else
                Payment has been done and the uploaded content will be aired as show in the booking info
                @endif
            @elseif ($advert->isRejected())
                <div class="mb-2">
                    This advert is not appropriate to be aired on our partners' screens
                </div>
                <form action="{{ route('platform.ads.delete', $advert->id) }}" method="post" class="d-block mt-2">
                    @csrf
                    <button class="btn btn-link px-0 py-1"><i class="fa fa-trash mr-1"></i>Delete Ad</button>
                </form>
            @else
                This advert is pending approval from our moderators. You'll be notified when this is done
            @endif
        </div>

        <div class="rounded-lg shadow-sm bg-white mb-4">
            <div class="embed-responsive embed-responsive-16by9 media-bg">
                <div class="embed-responsive-item">

                    <div class="mb-2 rounded-lg w-100" style="background: #ececec">
                        @if($advert->hasImageMedia())
                        <img src="{{ $advert->media_path }}" class="img-fluid rounded-top">
                        @else
                        <video controls muted src="{{ $advert->media_path }}" class="img-fluid" type="video/*"></video>
                        @endif
                    </div>

                </div>
            </div>

            <div class="px-3 py-3">

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="font-weight-600 mb-0">Description:</h6>
                    </div>

                    <div class="col-sm-9">
                        {{ $advert->description }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="font-weight-600 mb-0">Category:</h6>
                    </div>

                    <div class="col-sm-9">
                        {{ $advert->category_name }}
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-sm-3">
                        <h6 class="font-weight-600 mb-0 mb-sm-2">Submitted:</h6>
                    </div>

                    <div class="col-sm-9">
                        {{ $advert->fmt_date }}
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg px-3 py-4 mb-4">

            {{-- <div class="mb-3">
                <div>
                    <strong class="font-weight-600"><i class="fa fa-plus text-muted mr-1"></i>Recreate Ad</strong>
                </div>
                Create a new ad from this ad's content<br>
                <a href="{{ route('web.adverts.recreate', $advert->id) }}" class="btn btn-link px-0 py-1">Recreate</a>
            </div> --}}

            <div>
                <h5 class="font-weight-600">Invoicing</h5>
                @if($advert->invoice != null)
                <div class="mb-2">
                    This ad has an invoice generated on {{ $advert->invoice->fmt_date }}. View to see payment info
                </div>
                <a href="{{ route('platform.invoices.single', $advert->invoice->number) }}" class="btn btn-outline-primary shadow-none btn-sm">View Invoice</a>
                @else
                An invoice will be generated and emailed to you once the ad is approved. You'll also be able to view and download it it anytime
                @endif
            </div>

            <hr class="my-3">

            <div>
                <h5 class="font-weight-600">Delete Ad</h5>
                @if($advert->isRejected())
                <div class="mb-2">
                    Delete this ad from your history
                </div>
                <form id="del-form" action="{{ route('platform.ads.delete', $advert->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-primary btn-sm shadow-none">Delete Advert</button>
                </form>
                @else
                You can delete this ad when bookings have fully aired or when it is rejected
                @endif
            </div>
        </div>

    </div>

    <div class="col-md-6 col-lg-6">

        <div class="mb-4">
            <h5 class="font-weight-600">Bookings</h5>

            <p>You booked the following slots:</p>

                @php
                    $total_price = 0;
                @endphp

                @foreach($advert->bookings as $booking)
                <div class="shadow-sm mb-3 pt-3 pb-2 rounded-lg px-3 bg-white">
                    <div class="d-flex align-items-center mb-2">
                        <span class="rounded-circle bg-warning text-white d-inline-flex mr-3 align-items-center justify-content-center" style="min-width: 35px; height: 35px">
                            <i class="fa fa-video-camera"></i>
                        </span>
                        <h6 class="mb-0"><strong>{{ $booking->screen->name.' - '.$booking->package->summary.' - '.$booking->fmt_price }}</strong></h6>
                    </div>

                    <div>
                        @if($booking->total_dates == 1)
                            <div class="mb-2">
                                <span class="d-inline-flex rounded-circle small text-white mr-1 align-items-center justify-content-center" style="min-width: 30px; height: 30px; background: #ff7f5090">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                1 Date - {{ $booking->all_dates[0] ?? '' }}
                            </div>
                        @else
                        <div class="mt-2" style="white-space: nowrap; overflow-x: auto; scrollbar-width: thin">
                            @foreach($booking->all_dates as $date)
                            <span class="d-inline-block px-3 py-2 mb-2 mr-1 small font-weight-600" style="border-radius: 20px; background: #eaeaea">
                                {{ $date }}
                            </span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                @php
                    $total_price += $booking->price;
                @endphp
                @endforeach

                <h4 class="mb-0">Total Price: {{ 'KSh '.number_format($total_price) }}</h4>
        </div>

    </div>

</div>


@endif
@endsection
