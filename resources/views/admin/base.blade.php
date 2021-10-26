@extends('root')

@section('links')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('body')

<aside class="sidebar">
    <div class="scroll-wrapper">

        <div class="sidebar-header bg-gradient-danger shadow-sm">
            <h4 class="d-block mb-0 mx-auto">
                <a class="font-weight-800 text-white" style="color: #fff !important" href="{{ route('admin.dashboard') }}">
                    {{ config('app.name') }}
                </a>
            </h4>
        </div>

        <div class="scroll-inner">

            <div class="sidebar-inner py-4">
                <div>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.dashboard'){{ __('active') }}@endif " href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-line-chart text-primary mr-1"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.ads.all'){{ __('active') }}@endif" href="{{ route('admin.ads.all', ['status' => 'pending']) }}">
                                <i class="fa fa-bullhorn text-yellow mr-1"></i>
                                <span class="nav-link-text">View Adverts</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.schedule.view'){{ __('active') }}@endif" href="{{ route('admin.schedule.view') }}">
                                <i class="fa fa-calendar text-primary mr-1"></i>
                                <span class="nav-link-text">Scheduling</span>
                            </a>
                        </li>

                    </ul>

                    <h4 class="sidebar-heading text-muted">Advertising</h4>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.categories.all'){{ __('active') }}@endif " href="{{ route('admin.categories.all') }}">
                                <i class="ni ni-bullet-list-67 text-default mr-1"></i>
                                <span class="nav-link-text">Categories</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.screens.all'){{ __('active') }}@endif " href="{{ route('admin.screens.all') }}">
                                <i class="fa fa-tv text-info mr-1"></i>
                                <span class="nav-link-text">Screens</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.packages.all'){{ __('active') }}@endif " href="{{ route('admin.packages.all') }}">
                                <i class="ni ni-box-2 text-warning mr-1"></i>
                                <span class="nav-link-text">Packages</span>
                            </a>
                        </li>
                    </ul>

                    <h4 class="sidebar-heading text-muted">Clients</h4>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.clients.all'){{ __('active') }}@endif" href="{{ route('admin.clients.all') }}">
                                <i class="ni ni-circle-08 text-indigo mr-1"></i>
                                <span class="nav-link-text">View Clients</span>
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.agents'){{ __('active') }}@endif" href="{{ route('admin.agents') }}">
                                <i class="fa fa-handshake-o text-warning mr-1"></i>
                                <span class="nav-link-text">Manage Agents</span>
                            </a>
                        </li> --}}
                    </ul>

                    <h4 class="sidebar-heading text-muted">Billing</h4>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.billing.invoices'){{ __('active') }}@endif" href="{{ route('admin.billing.invoices') }}">
                                <i class="ni ni-money-coins text-success mr-1"></i>
                                <span class="nav-link-text">Invoices</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.billing.stats'){{ __('active') }}@endif" href="{{ route('admin.billing.stats') }}">
                                <i class="fa fa-bar-chart text-primary mr-1"></i>
                                <span class="nav-link-text">Statistics</span>
                            </a>
                        </li>
                    </ul>

                    @if($user->isAdmin())

                    <h4 class="sidebar-heading text-muted">Staff Accounts</h4>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.staff.all'){{ __('active') }}@endif" href="{{ route('admin.staff.all') }}">
                                <i class="ni ni-single-02 text-muted mr-1"></i>
                                <span class="nav-link-text">Manage Staff</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.staff.add'){{ __('active') }}@endif" href="{{ route('admin.staff.add') }}">
                                <i class="fa fa-plus text-warning mr-1"></i>
                                <span class="nav-link-text">Add Account</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.staff.activity'){{ __('active') }}@endif" href="{{ route('admin.staff.activity') }}">
                                <i class="fa fa-history text-info mr-1"></i>
                                <span class="nav-link-text">View Activity</span>
                            </a>
                        </li>
                    </ul>

                    @endif

                    <h4 class="sidebar-heading text-muted">Other</h4>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link @if($current_route_name == 'admin.staff.password'){{ __('active') }}@endif" href="{{ route('admin.staff.password') }}">
                                <i class="fa fa-lock text-muted mr-1"></i>
                                <span class="nav-link-text">Change Password</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </div>
</aside>

<main class="main-content">
    <nav class="header bg-gradient-danger">

        <style>
            .page-heading, .page-heading i{ color: #fff !important; }
            .page-heading i{
                display: inline-flex;
                width: 35px;
                height: 35px;
                border-radius: 50%;
                background: #eeeeee50;
                align-items: center;
                justify-content: center;
                font-size: .6em !important;
            }
        </style>
        <h4 class="mb-0 d-flex align-items-center font-weight-600 page-heading" style="color: #fff !important">
            @yield('page_heading')
        </h4>

        <div class="dropdown float-right ml-auto">
            <ul class="dropdown-menu">
                <li class="dropdown-item py-0">
                    <a href="{{ route('admin.staff.password') }}" class="py-3 d-flex align-items-center text-border">
                        <i class="fa fa-lock mr-3 text-success"></i>Change Password
                    </a>
                </li>

                <li class="dropdown-divider my-0"></li>

                <li class="dropdown-item py-0">
                    <a href="{{ route('admin.logout') }}" class="py-3 d-flex align-items-center text-border">
                        <i class="fa fa-power-off mr-3 text-danger"></i>Log Out
                    </a>
                </li>
            </ul>

            <div class="float-right ml-auto d-flex align-items-center dropdown-toggle btn btn-rounded btn-outline-white py-2" data-toggle="dropdown">
                {{ $user->name }}
            </div>
        </div>

    </nav>

    <div class="py-4 px-4 content">
        @yield('content')
    </div>
</main>

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

