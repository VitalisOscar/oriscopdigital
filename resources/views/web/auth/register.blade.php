@extends('web.layouts.app')

@section('title', 'Create an account')

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

    <div class="container">
        <div class="mx-auto" style="width: 350px; max-width: 100%">
            <div class="px-sm-4 mb-3 py-4 shadow-sm bg-white rounded auth-card">
                <div class="text-center mb-3">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.png') }}" class="d-inline-block mx-auto mb-4" height="60px" alt="">
                    </a>
                    <p class="mb-2">Create a client account</p>
                    <span class="d-inline-block px-5 bg-dark rounded" style="height: 3px"></span>
                </div>
                <form method="POST">
                    @csrf

                    @if(count($errors->all()) > 0)
                    <div class="text-danger mb-2">{{ $errors->all()[0] }}</div>
                    @endif

                    <div class="form-group form-group-custom">
                        <label><strong>Name:</strong></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group form-group-custom">
                        <label><strong>Email Address:</strong></label>
                        <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                        <small>You'll use this to sign in. We will also send you important communications</small>
                    </div>

                    <div class="form-group form-group-custom">
                        <label><strong>Phone Number:</strong></label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" minlength="10" maxlength="10" placeholder="e.g 0700123456" required>
                        <small>Use a 10 digit phone number e.g 0700123456</small>
                    </div>

                    <div class="form-group form-group-custom">
                        <label><strong>Set a Password:</strong></label>
                        <div class="input-group input-group-alternative shadow-none border" id="password">
                            <input type="password" class="form-control" name="password" value="{{ old('password') }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <span style="cursor: pointer" class="text-primary toggle font-weight-600" onclick="toggle(event)">show</span>
                                </span>
                            </div>
                        </div>
                        <small>Use at least 8 characters</small>
                    </div>

                    <div class="mb-4">
                        <button class="btn btn-danger shadow-none btn-block">Register</button>
                    </div>

                    <div class="text-center" style="font-size: .9em">
                        <div>
                            Already registered? <a href="{{ route('platform.auth.login') }}">Back to login</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="text-center small">
                Powered by <a href="https://oriscop.com">Oriscop Solutions</a>. All rights reserved.
            </div>
        </div>
    </div>

</section>
@endsection

@section('scripts')
@if(session()->has('status'))
<script>showAlert('{{ session()->get("status") }}', 'Alert');</script>
@endif

<script>
    $('.input-group').click(function(){
        document.querySelector('.input-group input').focus();
    });

    function toggle(e){
        var p = $('#password input');
        if(p.attr('type') == 'text'){
            $('#password input').attr('type', 'password');
            $('#password .input-group-append .toggle').text('show');
        }else{
            $('#password input').attr('type', 'text');
            $('#password .input-group-append .toggle').text('hide');
        }
    }
</script>
@endsection
