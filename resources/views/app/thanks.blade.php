@extends('layouts.frontend')
@section('content')
	<div class="container-index">
		<div class="vertical-center inner-container col-md-10 col-md-offset-1" style="margin-top: 4%">
			<img src="{{ asset('images/logo.png') }}" style="width: 40%!important;display: block;margin:0 auto" class="img-responsive text-center" alt="">
			<div class="row">
				<h1 class="text-center col-md-6 col-md-offset-3" style="font-size: 40px"> GRACIAS POR VOTAR POR {{strtoupper($current_event->name)}} </h1>
			</div>
			<div class="row">
				<a class="text-center btn btn-primary col-xs-4 btn-lg col-md-6 col-md-offset-3" href="{{ url('/home') }}" title="" class="">Volver</a>
			</div>
		</div>
	</div>
@endsection