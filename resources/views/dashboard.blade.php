@extends('layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            
                <div class="card-header">{{ __('Dashboard') }}  </div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" onclick="this.parentElement.style.display='none'" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                  
                    <strong>{{ Auth::user()->name }}</strong> {{__('You are Logged In')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
