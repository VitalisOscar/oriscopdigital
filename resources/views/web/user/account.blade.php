@extends('web.layouts.user_area')

@section('title', 'Your Account')

@section('section_heading', 'Manage Account')

@section('content')

<style>
    .form-control:disabled{
        background: #eee;
        border: none;
    }
</style>

<div class="row">
    <div class="col-md-6 col-lg-7">

        <div class="mb-4">
            <form method="POST">
                @csrf

                <p>View your personal information. This information is usually verified and hence cannot be freely updated</p>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col-sm-3 col-md-12 col-lg-4 d-flex align-items-center">
                            <strong>Name:</strong>
                        </div>

                        <div class="col-sm-9 col-md-12 col-lg-8">
                            <input class="form-control" value="{{ $user->name }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col-sm-3 col-md-12 col-lg-4 d-flex align-items-center">
                            <strong>Email:</strong>
                        </div>

                        <div class="col-sm-9 col-md-12 col-lg-8">
                            <input class="form-control" value="{{ $user->email }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-row">
                        <div class="col-sm-3 col-md-12 col-lg-4 d-flex align-items-center">
                            <strong>Phone No:</strong>
                        </div>

                        <div class="col-sm-9 col-md-12 col-lg-8">
                            <input class="form-control" value="{{ $user->phone }}" disabled>
                        </div>
                    </div>
                </div>

                {{-- <div class="form-group mb-4">
                    <div class="form-row">
                        <div class="col-sm-3 col-md-12 col-lg-4 d-flex align-items-center">
                            <strong>Your Phone No:</strong>
                        </div>

                        <div class="col-sm-9 col-md-12 col-lg-8">
                            <input class="form-control" value="{{ $user->operator_phone }}" name="phone" required>
                        </div>
                    </div>
                </div>

                <div>
                    <button class="btn btn-default py-2 shadow-none">Save Changes</button>
                </div> --}}
            </form>
        </div>


        <div class="mb-4 with-loader" id="verification_status">

            <div class="loader">
                <div class="text-center">
                    <span class="spinner spinner-border text-primary d-inline-block mb-2"></span><br>
                    <strong>Please wait...</strong>
                </div>
            </div>

            <h5 class="font-weight-600">Account Verification</h5>

            <p>
                To ensure that we have contact information from the rightful person, we require your account to be verified
            </p>

            <div>

                <div>
                    <h6 class="mb-1"><strong>Phone Number</strong></h6>
                    <p class="mb-0">
                        @if($user->hasPhoneVerified())
                        {{ 'Verified on '.$user->phone_verified_at }}
                        @else
                        <form method="POST" action="{{ route('platform.user.verify_phone') }}" id="email_verification_form" class="d-flex align-items-center">
                            @csrf
                            <span>Not Verified</span>
                            <button class="ml-auto float-right btn btn-link p-0">Verify Now</button>
                        </form>
                        @endif
                    </p>
                </div>

                <hr class="my-2">

                <div>
                    <h6 class="mb-1"><strong>Email Address</strong></h6>
                    <p class="mb-0">
                        @if($user->hasEmailVerified()))
                        {{ 'Verified on '.$user->email_veified_at }}
                        @else
                        <form method="POST" action="{{ route('platform.auth.verification.notice') }}" id="email_verification_form" class="d-flex align-items-center">
                            @csrf
                            @method('head')
                            <span>Not Verified</span>
                            <button class="ml-auto float-right btn btn-link p-0">Verify Now</button>
                        </form>
                        @endif
                    </p>
                </div>

                <hr class="my-2">
            </div>
        </div>

    </div>

    <div class="col-md-6 col-lg-5 pl-lg-5">

        <div>
            <h5 class="font-weight-600">Change your Password</h5>

            <form action="{{ route('platform.user.password') }}" method="post">
                @csrf
                <div class="form-group">
                    <strong>Current Password:</strong>
                    <br><small>We need this to confirm that it is you making this change</small>
                    <input class="form-control" type="password" name="password" value="{{ old('password') }}" required>
                </div>

                <div class="form-group">
                    <strong>New Password:</strong>
                    <br><small>Enter the new password that you want to be using</small>
                    <input class="form-control" type="password" name="new_password" value="{{ old('new_password') }}" required>
                </div>

                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    <br><small>Retype your new password</small>
                    <input class="form-control" type="password" name="confirm_password" value="{{ old('confirm_password') }}" required>
                </div>

                <div>
                    <button class="btn btn-default btn-block py-2 shadow-none"><i class="fa fa-lock mr-2"></i>Save Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session()->has('status_email'))
@include('web.user._email_verification_dialog')
@endif

@if(session()->has('get_code') || session()->has('status_phone'))
@include('web.dialogs.verify_phone')
@endif

@endsection

@section('scripts')
@if(count($errors) > 0)
<script>showAlert('{{ $errors->first() }}', 'Error');</script>
@endif

@if(session()->has('status'))
<script>showAlert('{{ session()->get("status") }}', 'Alert');</script>
@endif

@if(session()->has('status_email'))
<script>
    @if(session()->get('status_email'))
    $('#email_verification .success').removeClass('d-none');
    $('#email_verification .error').addClass('d-none');
    @else
    $('#email_verification .success').addClass('d-none');
    $('#email_verification .error').removeClass('d-none');
    @endif

    $('#email_verification').modal({
        backdrop: 'static'
    });
</script>
@endif

@if(session()->has('get_code') || session()->has('status_phone'))
<script>
    @if(session()->has('status_phone'))
    // Hide form
    $('#phone_verification .form').addClass('d-none');

        @if(session()->has('status_phone')) && session()->get('status_phone'))
        // Verified successfully
        $('#phone_verification .success').removeClass('d-none');
        $('#phone_verification .error').addClass('d-none');
        @else
        // error
        $('#phone_verification .success').addClass('d-none');
        $('#phone_verification .error').removeClass('d-none');
        @endif

    @else
    // show form
    $('#phone_verification .success').addClass('d-none');
    $('#phone_verification .error').addClass('d-none');
    $('#phone_verification .form').removeClass('d-none');
    @endif

    $('#phone_verification').modal({
        backdrop: 'static'
    });
</script>
@endif
@endsection
