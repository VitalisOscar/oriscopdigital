@extends('root')

@section('title', 'Administration | Log in')

@section('body')

    <section class="d-flex align-items-center" style="min-height: 100vh">
        <div class="container">

            <div class="mx-auto shadow rounded bg-white p-4" style="width: 300px; max-width: 100%;">

                <img src="{{ asset('img/logo.png') }}" class="d-block mx-auto mb-4" height="80px" alt="">

                <p class="lead text-center">Admin Login</p>

                <div>
                    <form action="" method="post" class="">
                        @csrf

                        <div class="form-group mb-4">
                            <label class="mb-0">Your Username:</label>
                            <div class="input-group mb-3">
                                <input type="text" name="username" class="form-control" placeholder="admin" value="{{ old('username') }}" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fa fa-user"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="mb-0">Password:</label>
                            <div class="input-group mb-3">
                                <input type="password" name="password" class="form-control" placeholder="password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fa fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="custom-control custom-checkbox">
                                <input id="rm" class="custom-control-input" type="checkbox" name="remember">
                                <label for="rm" class="custom-control-label mb-2">
                                    <span>Remember Me</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-dark btn-block shadow-none">Sign In</button>
                        </div>

                        @if($errors->has('status'))
                        <div class="pt-2">
                            <span class="small text-danger">{{ $errors->get('status')[0] }}</span>
                        </div>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    </section>

@endsection

@section('scripts')
@if($errors->has('status'))
<script>
    showAlert("{{ $errors->get('status')[0] }}", 'Error');
</script>
@endif
@endsection
