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
                    <div class="card-header">{{__('Register')}}</div>
                    <div class="card-body">
                        @include('flash')

                        <form action="{{ route('register.post') }}" method="POST" id="regform">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{__('Name')}}</label>
                                <div class="col-md-6">
                                    <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}">
                                    @if ($errors->has('name'))
                                    <strong><span class="text-danger">{{ $errors->first('name') }}</span></strong>
                                    @endif
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">{{__('Username')}}</label>
                                <div class="col-md-6">
                                    <input type="text" id="username" class="form-control" name="username" value="{{old('username')}}">
                                    @if ($errors->has('username'))
                                    <strong><span class="text-danger">{{ $errors->first('username') }}</span></strong>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">{{__('E-Mail Address')}}</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" value="{{old('email')}}">
                                    @if ($errors->has('email'))
                                    <strong><span class="text-danger">{{ $errors->first('email') }}</span></strong>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile_no" class="col-md-4 col-form-label text-md-right">{{__('Mobile Number')}}</label>
                                <div class="col-md-6">
                                    <input type="text" id="mobile_number" class="form-control" name="mobile_no" value="{{old('mobile_no')}}">
                                    @if ($errors->has('mobile_no'))
                                    <strong><span class="text-danger">{{ $errors->first('mobile_no') }}</span></strong>
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
                            </div>
                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-right">{{__('Country')}}</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="country-dropdown" name="country">
                                        <option value="">{{__('Select Country')}}</option>
                                         @foreach ($countries as $country)
                                    <option value="{{$country->id}}" >
                                        {{$country->name}}
                                        </option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="state" class="col-md-4 col-form-label text-md-right">{{__('State')}}</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="state-dropdown" name="state">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{__('City')}}</label>
                                <div class="col-md-6">
                                    <select class="form-control" id="city-dropdown" name="city">
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> {{__('Remember Me')}}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{__('Register')}}
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#country-dropdown').on('change', function() {
            var country_id = this.value;

            $("#state-dropdown").html('');
            $.ajax({

                url: "{{url('get-states-by-country')}}",
                type: "POST",
                data: {
                    country_id: country_id,
                    _token: '{{csrf_token()}}'
                },

                dataType: 'json',

                success: function(result) {

                    $('#state-dropdown').html('<option value="">{{__("Select State")}}</option>');
                    $.each(result.states, function(key, value) {

                        $("#state-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('#city-dropdown').html('<option value="">{{__("Select State First")}}</option>');
                }


            });
        });
        $('#state-dropdown').on('change', function() {
            var state_id = this.value;

            $("#city-dropdown").html('');
            $.ajax({
                url: "{{url('get-cities-by-state')}}",
                type: "POST",
                data: {
                    state_id: state_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#city-dropdown').html('<option value="">Select City</option>');
                    $.each(result.cities, function(key, value) {
                        $("#city-dropdown").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });
    });
</script>
