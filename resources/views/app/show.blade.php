@extends('layouts.frontend')

@section('content')
<div class="container-index">
    <div class="vertical-center inner-container col-md-10 col-md-offset-1" style="margin-top: 2%">
    	 <img src="{{ asset('images/logo.png') }}" style="width: 70%;display: block;margin:0 auto" class="img-responsive text-center" alt="">
        <h1 class="text-center"> {{config('app.name')}} - {{date('Y')}}  </h1>
    </div>
</div>
@endsection();