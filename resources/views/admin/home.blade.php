@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-5 col-md-offset-4">
		<div class="panel panel-default">
		    <div class="panel-heading">Selección de Evento Actual</div>

		    <div class="panel-body">
		        @if (session('status'))
		            <div class="alert alert-success">
		                {{ session('status') }}
		            </div>
		        @endif
		        <p class="text-center"><b>{{$currentEvent}}</b></p>
		        <form action="{{ route('set-current-event') }}" method="POST">
		        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		        	<label class="control-label col-md-12">Eventos</label>
		        	<div class="form-group col-md-9 @if($errors->has('event_id')) has-error @endif">
				        <select class="form-control" name="event_id">
				        	@foreach ($events as $event)
				        		<option value="{{$event->id}}">{{$event->name}}</option>
				        	@endforeach
				        </select>
		        	</div>
		        	<div class="col-md-3">
				        <button type="submit" class="btn btn-primary">Guardar</button>
		        	</div>
		        </form>
		    </div>
		</div>
	</div>
</div>

<div class="row">
	@foreach ($events as $event)
		<div class="col-md-6">
			<h4><b>{{$event->name}}</b></h4>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>header</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>data</td>
					</tr>
				</tbody>
			</table>
		</div>
	@endforeach
</div>
@endsection
