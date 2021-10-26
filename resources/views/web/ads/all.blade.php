@php

$r = request();

$status = strtolower($r->get('status'));

if($status == 'approved'){
    $title = 'Approved Adverts';
}else if($status == 'pending'){
    $title = 'Pending Adverts';
}else if($status == 'rejected'){
    $title = 'Declined Adverts';
}else{
    $status = 'all';
    $title = 'Your Adverts';
}

@endphp

@extends('web.layouts.user_area')

@section('title', $title)

@section('content')

<div class="row">
    <div class="col-md-8">

        <div class="statuses mb-4">
            <a href="{{ route('platform.ads.all') }}" @if($status == 'all')class="active" @endif>All</a>
            <a href="{{ route('platform.ads.all', ['status' => 'pending']) }}" @if($status == 'pending')class="active" @endif>Pending</a>
            <a href="{{ route('platform.ads.all', ['status' => 'approved']) }}" @if($status == 'approved')class="active" @endif>Approved</a>
            <a href="{{ route('platform.ads.all', ['status' => 'rejected']) }}" @if($status == 'rejected')class="active" @endif>Rejected</a>
        </div>

        <style>
            .statuses{
                overflow-x: hidden;
                white-space: nowrap;
            }

            .statuses a{
                display: inline-block;
                color: #444;
                padding: 10px 15px;
                font-weight: 800;
                border-radius: .3rem;
                transition: .25s all !important;
                background: #eee;
            }

            .statuses a:not(:last-child){
                margin-right: 5px
            }

            .statuses a.active{
                background: #007cba;
                color: #fff;
            }

            .statuses a:not(.active):hover,
            .statuses a:not(.active):focus
            {
                color: #007cba;
            }
        </style>

        <div class="d-md-none mb-3">
            <div class="text-center">
                <button type="button" onclick="$('.filters-sm').toggleClass('show')" class="btn btn-outline-success shadow-none btn-block py-2 mb-3"><i class="fa fa-filter mr-1"></i>Filter Results<i class="fa fa-caret-down ml-3"></i></button>
            </div>

            <div class="collapse border bg-white p-4 filters-sm">

                @include('web.ads._filter_form')

            </div>
        </div>

        @if($result->isEmpty())
        <div>
            <p class="lead">
                You do not have any ads in this section. Change some of your filters or create an ad to see it here
            </p>

            <div>
                <a href="{{ route('platform.ads.create') }}" class="btn btn-link p-0"><i class="fa fa-plus mr-1"></i>Upload An Ad</a>
            </div>
        </div>
        @endif

        <div class="row">
            @foreach($result->items as $ad)
            <article class="col-12 col-sm-6 mb-3">
                <div class="bg-white rounded ad">
                    <div class="px-0">

                        <div class="w-100 d-flex align-items-center h-100 bg-lighter">
                            <div class="embed-responsive embed-responsive-16by9 rounded-top">
                                <div class="embed-responsive-item">
                                    @if($ad->hasImageMedia())
                                    <img src="{{ $ad->media_path }}" class="img-fluid">
                                    @else
                                    <video controls muted src="{{ $ad->media_path }}" class="img-fluid" type="video/*"></video>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="px-3 py-3">
                        <h6><strong>{{ $ad->time }}</strong></h6>

                        @if($ad->isApproved())
                        <p class="description">
                            {{ $ad->description }}
                        </p>
{{--
                        <div class="mb-3 font-weight-700">
                            {{ 'KSh 24,000' }}
                        </div> --}}
                        @else
                        <p class="description">
                            {{ $ad->description }}
                        </p>
                        @endif

                        <div class="mb-3">
                            <span class="mr-3">
                                <i class="fa fa-bullhorn text-muted font-weight-bold mr-1"></i>{{ $ad->category_name }}
                            </span>

                            <span>
                                <i class="fa fa-check-square text-muted font-weight-bold mr-1"></i>{{ $ad->status }}
                                {{-- <i class="fa fa-video-camera text-muted font-weight-bold mr-1"></i>{{ $ad->slots }} @if($ad->slots != 1){{ __('Bookings') }}@else{{ __('Booking') }}@endif --}}
                            </span>
                        </div>

                        <div class="d-flex">
                            @if($ad->isApproved())
                            @if(!$ad->isPaidFor())
                            <form action="{{ route('platform.invoices.pay', $ad->invoice->number) }}" method="get" class="w-50">
                                <button class="btn btn-block btn-outline-success btn-sm shadow-none mr-1"><i class="ni ni-money-coins mr-1"></i>Pay Now</button>
                            </form>
                            @else
                            <span class="w-50">
                                <i class="ni ni-money-coins text-success"></i>&nbsp;Paid
                            </span>
                            @endif
                            @endif
                            <a href="{{ route('platform.ads.single', $ad->id) }}" class="ml-1 w-50 btn btn-primary shadow-none btn-sm">View Details&nbsp;<i class="fa fa-share"></i></a>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        @if(!$result->isEmpty())
        <div class="pt-2 d-flex align-items-center">
            @if($result->hasPreviousPage())
                <a href="{{ $result->prevPageUrl() }}" class="mr-auto btn btn-primary shadow-none py-2"><i class="fa fa-angle-double-left mr-1"></i>Prev</a>
            @endif

            <span>Page {{ $result->page }} of {{ $result->max_pages }}</span>

            @if($result->hasNextPage())
                <a href="{{ $result->nextPageUrl() }}" class="ml-auto btn btn-primary shadow-none py-2">Next<i class="fa fa-angle-double-right ml-1"></i></a>
            @endif
        </div>
        @endif

    </div>

    <div class="col-md-4 d-none d-md-block">
        <div class="border bg-white rounded p-4">

            <h4 class="font-weight-600"><i class="fa fa-filter mr-3"></i>Filters</h4>

            @include('web.ads._filter_form')

        </div>
    </div>
</div>

@endsection
