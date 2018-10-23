@extends('layouts.frontend')

@section('content')
<div class="container-index">
    <div class="vertical-center inner-container col-md-10 col-md-offset-1">
    	<img src="{{ asset('images/logo.png') }}" style="width: 15%;display: block;margin:0 auto" class="img-responsive text-center" alt="">
        <h1 class="text-center"> {{config('app.name')}} {{date('Y')}} - {{$current_event->name}} </h1>
        @foreach ($misses as $miss)
	        <h3 class="text-center"><b><span style="color: #ff7200">{{strtoupper($miss->city->name)}}</span> - {{explode(' ',$miss->name)[0]}} {{explode(' ',$miss->last_name)[0]}}</b></h3>
	        <div class="col-md-8">
	        	<img src="{{ asset($miss->photos) }}" alt="" class="img-responsive text-center img-block" style="width: 42%!important">
	        </div>
	        <div class="col-md-4">
	        	<div class="data-section">
	        		<h4 class="text-center"><b>Datos</b></h4>
		        	<ul class="list-unstyled">
		        		<li><b>Nombres:</b> {{$miss->name}} {{$miss->last_name}}</li>
		        		<li><b>Edad:</b> {{$miss->age}} Años</li>
		        		<li><b>Estatura:</b> {{$miss->height}}</li>
		        		<li><b>Medidas:</b> {{$miss->measurements}}</li>
		        		<li><b>Hobbies:</b> {{$miss->hobbies}}</li>
		        	</ul>
		        	<hr>
		        	<form action="{{ route('dovote') }}" method="get" accept-charset="utf-8">
		        		{{ csrf_field() }}
		        		<h3 class="text-center"><b>Puntaje</b></h3>
		        		<input type="hidden" name="event_id" value="{{$current_event->id}}">
		        		<input type="hidden" name="user_id" value="{{Auth::id()}}">
		        		<input type="hidden" name="miss_id" value="{{Auth::id()}}">
		        		<select name="value" class="form-control" id="puntaje">
		        			<option value="null">Seleccione</option>
		        			@for ($i = 0; $i <=10 ; $i++)
		        				<option value="{{$i}}">{{$i}} Puntos</option>
		        			@endfor
		        		</select>
		        		<button type="submit" class="btn btn-vote btn-block"><i class="fa fa-heart"></i> <b>VOTAR</b></button>
		        	</form>
		        	<hr>
	        	</div>
	        </div>
        @endforeach
        <div class="col-md-12 text-center">
        	{{$misses->links()}}
        </div>
    </div>
</div>
@endsection()