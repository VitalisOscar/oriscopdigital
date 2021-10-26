@extends('web.layouts.app')

@section('title', 'Log into your account')

@section('body')
<style>

    @media(max-width: 576px){
        .auth-card{
            border: none !important;
            box-shadow: none !important;
        }

        body{background: #fff}
    }
</style>
<section class="py-5">
    <div class="mx-auto" style="width: 350px; max-width: 100%">
        <div class="px-sm-4 mb-3 py-4 shadow-sm bg-white rounded auth-card">
            <div class="text-center mb-3">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.png') }}" class="d-inline-block mx-auto mb-4" height="60px" alt="">
                </a>
                <p class="mb-2">Sign in to your client account</p>
                <span class="d-inline-block px-5 bg-dark rounded" style="height: 3px"></span>
            </div>
            <form method="POST">
                @csrf

                @if(count($errors->all()) > 0)
                <div class="text-danger mb-2">{{ $errors->all()[0] }}</div>
                @endif

                <div class="form-group">
                    <label class="mb-0"><strong>Email Address:</strong></label><br>
                    <small class="mb-2 d-inline-block">Enter the email you registered with</small>
                    <input class="form-control" name="email" placeholder="e.g info@companyx.com" type="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label><strong>Your Password:</strong></label>
                    <input type="password" class="form-control" placeholder="e.g wtf5ccPKn" name="password" value="{{ old('password') }}" required>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input id="rm" class="custom-control-input" type="checkbox" name="remember_me">
                        <label for="rm" class="custom-control-label mb-2">
                            <span>Remember Me</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <button class="btn btn-danger shadow-none btn-block">Log In</button>
                </div>

                <div class="text-center" style="font-size: .9em">
                    <div class="mb-3">
                        Forgot your password? <a href="{{ route('platform.auth.password.request') }}">Reset it</a>
                    </div>

                    <div>
                        Need an account? <a href="{{ route('platform.auth.register') }}">Sign up now</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="text-center small">
            Powered by <a href="https://oriscop.com">Oriscop Solutions</a>. All rights reserved.
        </div>
    </div>

</section>
@endsection

@section('scripts')
@if(session()->has('status'))
<script>showAlert('{{ session()->get("status") }}', 'Alert');</script>
@endif
@endsection
