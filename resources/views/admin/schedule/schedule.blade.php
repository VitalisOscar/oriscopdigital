@extends('admin.base')

@section('title', 'Airing Schedule')

@section('page_heading')
<i class="fa fa-calendar text-success mr-3" style="font-size: .8em"></i>
Schedule
@endsection

@section('content')

@php
    $packages = \App\Models\Package::all();
    $screens = \App\Models\Screen::all();
@endphp

<div class="d-flex align-items-center mb-3 pb-3 border-bottom">
    <div class="mr-3">
        <h4 class="mb-0">
            Slots
        </h4>
    </div>

    <form class="d-flex align-items-center mr-3 ml-auto" method="GET">
        <?php $request = request(); ?>

        <div class="ml-3 d-flex align-items-center ml-auto">
            <div class="clearfix mr-3">
                <select name="screen" class="nice-select" onchange="document.querySelector('#screen_post').selectedIndex = this.selectedIndex">
                    <option value="">Screen</option>
                    @foreach($screens as $s)
                    <option value="{{ $s->id }}" @if($request->get('screen') == $s->id) selected @endif>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="clearfix mr-3">
                <select name="package" class="nice-select" onchange="document.querySelector('#package_post').selectedIndex = this.selectedIndex">
                    <option value="">Package</option>
                    @foreach($packages as $p)
                    <option value="{{ $p->id }}" @if($request->get('package') == $p->id) selected @endif>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mr-3">
                <input type="date" oninput="document.querySelector('#date_post').value = this.value" name="date" value="{{ $date }}" class="form-control">
            </div>

            <div class="">
                <button class="btn btn-success shadow-none"><i class="fa fa-video mr-1"></i>View Schedule</button>
            </div>
        </div>

    </form>

    <form action="{{ route('admin.schedule.download') }}" method="GET" class="">
        <div class="d-none">
            <select name="screen" id="screen_post">
                <option value=""></option>
                @foreach($screens as $s)
                <option value="{{ $s->id }}" @if($request->get('screen') == $s->id) selected @endif>{{ $s->title }}</option>
                @endforeach
            </select>

            <select name="package" id="package_post">
                <option value=""></option>
                @foreach($packages as $p)
                <option value="{{ $p->id }}" @if($request->get('package') == $p->id) selected @endif>{{ $p->name }}</option>
                @endforeach
            </select>

            <input type="text" name="date" id="date_post" value="{{ $date }}">
        </div>

        <button class="btn btn-default shadow-none"><i class="fa fa-download mr-1"></i>Download</button>
    </form>

</div>

@if(count($adverts) > 0)
<div class="table-responsive">
    <table class="table bg-white border">
        <tr class="bg-default text-white">
            <th class="text-center border-right px-4">#</th>
            <td>Content Type</td>
            <th>About</th>
            <th>Client</th>
            <th></th>
        </tr>

        <?php $i = 1; ?>
        @foreach($adverts as $advert)
        <tr>
            <td class="text-center border-right">{{ $i++ }}</td>
            <td>{{ $advert->media_type }}</td>
            <td>{{ $advert->description }}</td>
            <td>{{ $advert->user->name }}</td>
            <td>
                <a class="btn btn-sm btn-outline-primary shadow-none mr-3" href="{{ route('admin.ads.single', $advert->id) }}">View Ad</a>
                {{-- <a class="btn btn-sm btn-outline-primary shadow-none" href="{{ route('admin.schedule.download.single', ['slot'=>$advert->id]) }}">Download</a> --}}
            </td>
        </tr>
        @endforeach

    </table>
</div>

@else
<p class="lead">
    There are no ads scheduled on {{ $fmt_date }}
</p>
@endif

@endsection
