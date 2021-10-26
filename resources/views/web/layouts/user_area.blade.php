@extends('root')

@section('body')
    <div class="bg-white sticky-top">

        <header class="navbar py-2 px-0 px-sm-3 section-shaped position-relative">

            <div class="shape shape-light position-absolute top-0 bottom-0 right-0 left-0 bg-gradient-danger shape-style-1">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="container-fluid">
                <button class="navbar-toggler text-white d-none d-md-inline-block d-lg-none mr-3" onclick="$('#sidenav').toggleClass('open')">
                    <i class="fa fa-bars"></i>
                </button>

                <a href="{{ route('home') }}" class="navbar-brand mr-auto">
                    {{ config('app.name') }}
                    {{-- <img style="height: 50px" src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}"> --}}
                </a>

                <div class="ml-auto d-flex align-items-center">
                    <div class="d-none d-md-flex align-items-center">
                        <div class="links mr-3">
                            <a href="{{ route('platform.dashboard') }}">Dashboard</a>
                            {{-- <a href="{{ route('prese') }}">View Presence</a> --}}
                        </div>
                        <a href="{{ route('platform.invoices.all') }}" class="btn btn-white shadow-none py-2"><i class="fa fa-dollar mr-1"></i>Your Invoices</a>
                        <a href="{{ route('platform.ads.create') }}" class="btn btn-default shadow-none py-2"><i class="fa fa-upload mr-1"></i>Upload an Ad</a>
                    </div>

                    <button class="navbar-toggler text-white d-md-none" onclick="$('#sidenav').toggleClass('open')">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
            </div>
        </header>
    </div>

    <div class="container-fluid px-0 px-sm-3">
        <aside class="sidenav d-lg-block d-none" id="sidenav" onclick="if(event.target == this){ this.classList.remove('open') }">
            <div class="px-3 py-4">
                <div class="mb-3">
                    <div><strong>{{ $user->name }}</strong>
                    </div>
                    <div class="mb-2">{{ $user->email }}</div>
                    <div>
                        <a href="{{ route('platform.auth.logout') }}" class="btn btn-outline-danger btn-block shadow-none py-2"><i class="fa fa-power-off"></i> Sign Out</a>
                    </div>
                </div>

                <div class="sidenav-items mb-4">
                    <a href="{{ route('platform.dashboard') }}" @if($current_route_name == 'platform.dashboard') class="active"@endif ><i class="fa fa-user bg-default"></i>Dashboard</a>
                    <a href="{{ route('platform.ads.create') }}" @if($current_route_name == 'platform.ads.create') class="active"@endif ><i class="fa fa-upload bg-primary"></i>Upload Advert</a>
                    <a href="{{ route('platform.ads.all') }}" @if($current_route_name == 'platform.ads.all') class="active"@endif ><i class="fa fa-clock-o bg-info"></i>My Adverts</a>
                    <a href="{{ route('platform.user.account') }}" @if($current_route_name == 'platform.user.account') class="active"@endif ><i class="fa fa-user bg-indigo"></i>My Account</a>
                    <a href="{{ route('platform.invoices.all') }}" @if($current_route_name == 'platform.invoices.all') class="active"@endif ><i class="fa fa-money bg-warning"></i>My Invoices</a>
                </div>
            </div>
        </aside>

        <section class="py-4 py-sm-5 px-3 px-lg-4 pl-xl-4 main">
            @hasSection ('section_heading')
            <h4 class="heading-title mb-3">@yield('section_heading')</h4>
            @endif

            <div>

                @yield('content')

            </div>
        </section>
    </div>

@endsection

@section('scripts')
@if(session()->has('status'))
<script>
    showAlert("{{ session()->get('status') }}", 'Success');
</script>
@endif

@if($errors->has('status'))
<script>
    showAlert("{{ $errors->get('status')[0] }}", 'Error');
</script>
@endif

@yield('other_scripts')
@endsection
