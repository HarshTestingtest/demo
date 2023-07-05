@extends('layout')

@section('content')

@php
require_once(base_path().'/public/js/validation.php');
@endphp

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">{{__('Login')}}</div>
                    <div class="card-body">

                        @include('flash')

                        <form action="{{ route('login.post') }}" method="POST" id="login">
                            @csrf
                            <!-- <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                    <strong><span class="text-danger">{{ $errors->first('email') }}</span></strong>
                                    @endif
                                </div>
                            </div> -->

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">{{__('Username Or Email')}}</label>

                                <div class="col-md-6">
                                    <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}">

                                    @if ($errors->has('username'))
                                    <strong><span class="text-danger">{{ $errors->first('username') }}</span></strong>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{__('Password')}}</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password">
                                    @if ($errors->has('password'))
                                    <strong><span class="text-danger">{{ $errors->first('password') }}</span></strong>
                                    @endif
                                </div>
                                <a onclick="showPassword()"><i class="fa fa-eye"></i></a>

                            </div>

                            <div class="form-group row{{ $errors->has('captcha') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{__('Captcha')}}</label>


                                <div class="col-md-6">
                                    <div class="refereshrecapcha" style="float: left; margin-bottom: 15px;">
                                        {!! captcha_img('flat') !!}
                                    </div>
                                    <a style="margin-left:16px;cursor: pointer;" onclick="refreshCaptcha()"><i style="font-size:24px" class="fa">&#xf021;</i></a>

                                    <input id="captcha" class="form-control" type="text" name="captcha" data-validation="required">



                                    @if ($errors->has('captcha'))
                                    <strong><span class="text-danger">{{ $errors->first('captcha') }}</span></strong>
                                    @endif
                                </div>
                            </div>

                            <!-- <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div> -->

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <a href="{{ route('forget.password.get') }}">{{__('Reset Password')}}</a>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{__('Login')}}
                                </button>
                                <a class="btn btn-success" href="{{ route('otp.login') }}">
                                    {{__('Login with OTP')}}
                                </a>
                                <a class="btn btn-danger" href="{{ url('login/google') }}">
                                    {{__('Login with Google')}}
                                </a>
                            </div>



                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
    function refreshCaptcha() {
        $.ajax({
            url: "{{url('refereshcapcha')}}",
            type: 'get',
            dataType: 'html',
            success: function(json) {
                $('.refereshrecapcha').html(json);
            },
            error: function(data) {
                alert('Try Again.');
            }
        });
    }

    function showPassword() {
        if ($('#password').attr("type") == "text") {
            $('#password').attr('type', 'password');
        } else if ($('#password').attr("type") == "password") {
            $('#password').attr('type', 'text');
        }
    }
</script>
<script src="{{ asset('js/validation.js') }}" defer></script>