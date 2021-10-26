@extends('web.layouts.user_area')

@section('title', 'Platform Dashboard')

@section('section_heading', 'Platform Dashboard')

@section('content')

<div class="row">
    <div class="col-lg-9">

        <div class="row mb-2 d-none d-sm-flex">

            <div class="col-md-4 mb-4">
                <a href="{{ route('platform.ads.all', ['status' => 'approved']) }}" class="shadow-lg text-white rounded-lg d-block bg-success">
                    <div class="p-3">
                        <h4 class="font-weight-600 mb-2 text-white">Approved Ads</h4>

                        <div class="d-flex align-items-center">
                            <strong style="font-size: 1.5em">{{ $summary['approved'] }}</strong>
                            <i class="fa fa-check-circle float-right ml-auto" style="font-size: 1.5em"></i>
                        </div>
                    </div>

                    <div class="border-top border-white text-right small font-weight-600 p-3">
                        View All <i class="fa fa-arrow-right"></i>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('platform.ads.all', ['status' => 'rejected']) }}" class="shadow-lg text-white rounded-lg d-block bg-gradient-danger">
                    <div class="p-3">
                        <h4 class="font-weight-600 mb-2 text-white">Declined Ads</h4>

                        <div class="d-flex align-items-center">
                            <strong style="font-size: 1.5em">{{ $summary['rejected'] }}</strong>
                            <i class="fa fa-close float-right ml-auto" style="font-size: 1.5em"></i>
                        </div>
                    </div>

                    <div class="border-top border-white text-right small font-weight-600 p-3">
                        View All <i class="fa fa-arrow-right"></i>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('platform.ads.all', ['status' => 'pending']) }}" class="shadow-lg text-white rounded-lg d-block bg-gradient-indigo">
                    <div class="p-3">
                        <h4 class="font-weight-600 mb-2 text-white">Pending</h4>

                        <div class="d-flex align-items-center">
                            <strong style="font-size: 1.5em">{{ $summary['pending'] }}</strong>
                            <i class="fa fa-clock-o float-right ml-auto" style="font-size: 1.5em"></i>
                        </div>
                    </div>

                    <div class="border-top border-white text-right small font-weight-600 p-3">
                        View All <i class="fa fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mb-4 d-sm-none">
            <div class="col-x6">
                <a href="{{ route('platform.ads.all', ['status' => 'approved']) }}" class="d-flex align-items-center border rounded bg-white mb-3 p-3">
                    <span class="icon icon-shape bg-success text-white">
                        <i class="fa fa-check"></i>
                    </span>

                    <div class="ml-3 mr-3">
                        <div class="text-body">Approved Ads</div>
                        <h5 class="mb-0"><strong>{{ $summary['approved'] }}</strong></h5>
                    </div>

                    <span class="ml-auto mr-1 float-right">
                        <i class="fa fa-chevron-right text-muted"></i>
                    </span>
                </a>
            </div>

            <div class="col-x6">
                <a href="{{ route('platform.ads.all', ['status' => 'rejected']) }}" class="d-flex align-items-center border rounded bg-white mb-3 p-3">
                    <span class="icon icon-shape bg-gradient-danger text-white">
                        <i class="fa fa-times"></i>
                    </span>

                    <div class="ml-3 mr-3">
                        <div class="text-body">Declined Ads</div>
                        <h5 class="mb-0"><strong>{{ $summary['rejected'] }}</strong></h5>
                    </div>

                    <span class="ml-auto mr-1 float-right">
                        <i class="fa fa-chevron-right text-muted"></i>
                    </span>
                </a>
            </div>

            <div class="col-x6">
                <a href="{{ route('platform.ads.all', ['status' => 'pending']) }}" class="d-flex align-items-center border rounded bg-white mb-3 p-3">
                    <span class="icon icon-shape bg-info text-white">
                        <i class="fa fa-clock-o"></i>
                    </span>

                    <div class="ml-3 mr-3">
                        <div class="text-body">Pending Approval</div>
                        <h5 class="mb-0"><strong>{{ $summary['pending'] }}</strong></h5>
                    </div>

                    <span class="ml-auto mr-1 float-right">
                        <i class="fa fa-chevron-right text-muted"></i>
                    </span>
                </a>
            </div>
        </div>

        {{-- <div class="mb-3">
            @if($user->hasAccountVerified())
            <p class="info success">
                Your email and phone details are verified. You can now submit new adverts and manage your existing ones
                <br><a href="{{ route('platform.ads.create') }}" class="btn btn-link px-0 py-1"><i class="fa fa-plus mr-1"></i>Create a new Advert</a>
            </p>
            @else
            <p class="info danger">
                Your email and phone details are not fully verified. Until then, you will not be able to submit and manage adverts
                Visit your account to see status and verify<br><a href="{{ route('platform.user.account') }}" class="btn btn-link px-0 py-1"><i class="fa fa-user mr-1"></i>Go to Account</a>
            </p>
            @endif
        </div> --}}

        <div class="mb-3">
            <h4 class="font-weight-600">Recent Ads</h4>

            @if(count($recent_ads) == 0)
            <div>
                <p class="lead info p-3 rounded border-left-0 mt-0">
                    You have not submitted any ad recently. Click on 'Upload Ad' to begin advertising digitally with our partners
                </p>

                <a href="{{ route('platform.ads.create') }}" class="btn btn-link px-0 py-2"><i class="fa fa-plus mr-1"></i>Upload an Ad</a>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table- border">
                    <tr class="bg-primary text-white">
                        <th></th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>

                    @foreach ($recent_ads as $ad)
                    <tr>
                        <td style="vertical-align: middle">
                            <span class="rounded-circle text-success d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #eee">
                                <i class="fa fa-bullhorn" style="font-size: 1.2em"></i>
                            </span>
                        </td>
                        <td style="vertical-align: middle"><div style="max-height: 3rem; line-height: 1.5rem; overflow-y: hidden">{{ $ad->description }}</div></td>
                        <td style="vertical-align: middle">{{ $ad->category_name }}</td>
                        <td style="vertical-align: middle; text-align: center">{{ $ad->fmt_date }}</td>
                        <td style="vertical-align: middle; text-align: center">{{ $ad->status }}</td>
                        <td style="vertical-align: middle"><a href="{{ route('platform.ads.single', $ad->id) }}">View Ad</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif
        </div>

        <div>
            <h4 class="font-weight-600">Account Activity</h4>

            @if(count($notifications) == 0)
            <p class="lead mt-0">
                We will let you know when something happens regarding your account or your adverts
            </p>
            @endif

            @foreach($notifications as $notification)
            <div class="py-3 d-flex align-items-center">
                <span class="icon icon-shape bg-primary text-white mr-4">
                    <i class="fa fa-bell"></i>
                </span>

                <div>
                    <h6 class="mb-2"><strong>{{ $notification->title.' - '.$notification->time }}</strong></h6>
                    <p class="my-0">{{ $notification->content }}</p>
                </div>
            </div>

            <hr class="my-0">
            @endforeach
        </div>

    </div>

    <div class="col-lg-3">

        <h5><strong>Quick Actions</strong></h5>

        <div class="mb-3">
            <div class="mb-1"><a href="{{ route('platform.ads.create') }}">Submit your ad</a></div>
            <div class="mb-1"><a href="{{ route('platform.ads.all') }}">View your ads</a></div>
            <div class="mb-1"><a href="{{ route('platform.user.account') }}">Manage Account</a></div>
            <div class="mb-1"><a href="{{ route('platform.auth.logout') }}">Sign Out</a></div>
        </div>

        <div class="shadow-sm rounded-lg px-3 py-4 bg-gradient-default text-white">
            Note that the advertising screens you will book whe submitting your ad are provided by our partners, AlphaAndJam Ltd.
        </div>

    </div>


</div>

<style>
    .col-x6{
        width: 100%;
        padding: 0 .75rem;
    }

    @media(min-width: 400px){
        .col-x6{
            width: 50%;
        }
    }
</style>

@endsection
