@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default" id="current-event">
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

	<div class="col-md-4">
		<div class="panel panel-default"  id="reset-points">
		    <div class="panel-heading">Reinicializar Puntos</div>
		    <div class="panel-body">
		    	<form action="{{ route('reset') }}" method="post" id="reset-form">
		    		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		    		<button type="submit" class="btn btn-danger btn-block" onclick="event.preventDefault(); if(confirm('Esta seguro?')) { document.getElementById('reset-form').submit() } ">Aceptar</button>
		    	</form>
		    </div>
		</div>
	</div>

</div>


 <ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><a href="#events" aria-controls="events" role="tab" data-toggle="tab">Eventos</a></li>
	<li role="presentation"><a href="#faltantes" aria-controls="faltantes" role="tab" data-toggle="tab">Faltantes</a></li>
	<li role="presentation"><a href="#semifinalists" aria-controls="semifinalists" role="tab" data-toggle="tab">10 Semifinalistas</a></li>
	<li role="presentation"><a href="#finalists" aria-controls="finalists" role="tab" data-toggle="tab">5 Finalistas</a></li>
	<li role="presentation"><a href="#finalResult" aria-controls="finalResult" role="tab" data-toggle="tab">Resultado Final</a></li>
</ul>
<div class="row">
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="events">
			@foreach ($events as $event)
				<div class="col-md-6">
					<h4><b>{{$event->name}}</b></h4>
					<table class="table table-bordered table-responsive table-dashboard">
						<thead>
							<tr>
								<th>N°</th>
								<th>Cantón</th>
								@foreach ($judges as $judge)
								<th>{{$judge->username}}</th>
								@endforeach
								<th>SUMATORIA</th>
								<th>PROMEDIO</th>
							</tr>
						</thead>
						<tbody>
							@foreach (App\Score::getScore($event->id) as $key =>  $score)
								<tr class="@if( ($key + 1) == 1) success @endif">
									<td>{{($key + 1)}}</td>
									<td>@if( ($key + 1) == 1) <b> @endif{{$score->name}} @if( ($key + 1) == 1)</b>@endif</td>
									@for ($i = 0; $i < count($judges); $i++)
										@php $jueznum = "juez".($i+1); @endphp
										<td>{{$score->$jueznum}}</td>
									@endfor
									<td>{{$score->sumatoria}}</td>
									<td>{{$score->promedio}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endforeach
		</div>
		
		<div role="tabpanel" class="tab-pane" id="faltantes">
			<div class="col-md-12">
				<h4><b>Semifinalistas</b></h4>
				<table class="table table-bordered table-responsive table-dashboard">
					<thead>
						<tr>
							<th>N°</th>
							<th>Usuario</th>
							<th>Cantón</th>
							<th>Evento</th>
						</tr>
					</thead>
					<tbody>
						@foreach (App\Score::getFaltantes() as $key =>  $faltante)
							<tr>
								<td>{{($key + 1)}}</td>
								<td>{{$faltante->username}}</td>
								<td>{{$faltante->canton}}</td>
								<td>{{$faltante->evento}}</td>
							</tr>
						@endforeach
						<tr></tr>
					</tbody>
				</table>
			</div>
		</div>

		<div role="tabpanel" class="tab-pane" id="semifinalists">
			<div class="col-md-12">
				<h4><b>Semifinalistas</b></h4>
				<table class="table table-bordered table-responsive table-dashboard">
					<thead>
						<tr>
							<th>No</th>
							<th>Cantón</th>
							@foreach ($judges as $judge)
							<th>{{$judge->username}}</th>
							@endforeach
							<th>SUMATORIA</th>
							<th>PROMEDIO</th>
						</tr>
					</thead>
					<tbody>
						@foreach (App\Score::getScore(null,'semifinalist') as $key =>  $score)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$score->name}}</td>
								@for ($i = 0; $i < count($judges); $i++)
									@php $jueznum = "juez".($i+1); @endphp
									<td>{{$score->$jueznum}}</td>
								@endfor
								<td>{{$score->sumatoria}}</td>
								<td>{{$score->promedio}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<hr>
				<div class="col-md-2 col-md-offset-6">
					<a type="button" class="btn btn-default" href="{{ route('print',['type'=>'semifinalist']) }}" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
				</div>
			</div>
		</div>

		<div role="tabpanel" class="tab-pane" id="finalists">
			<div class="col-md-12">
				<h4><b>Semifinalistas</b></h4>
				<table class="table table-bordered table-responsive table-dashboard">
					<thead>
						<tr>
							<th>No</th>
							<th>Cantón</th>
							@foreach ($judges as $judge)
							<th>{{$judge->username}}</th>
							@endforeach
							<th>SUMATORIA</th>
							<th>PROMEDIO</th>
						</tr>
					</thead>
					<tbody>
						@foreach (App\Score::getScore(null,'finalist') as $key =>  $score)
							<tr>
								<td>{{$key+1}}</td>
								<td>{{$score->name}}</td>
								@for ($i = 0; $i < count($judges); $i++)
									@php $jueznum = "juez".($i+1); @endphp
									<td>{{$score->$jueznum}}</td>
								@endfor
								<td>{{$score->sumatoria}}</td>
								<td>{{$score->promedio}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<hr>
				<div class="col-md-2 col-md-offset-6">
					<a type="button" class="btn btn-default" href="{{ route('print',['type'=>'finalist']) }}" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
				</div>
			</div>
		</div>

		<div role="tabpanel" class="tab-pane" id="finalResult">
			<h1>Resultado Final</h1>
			<table class="table table-bordered table-dashboard">
				<thead>
						<tr>
							<th></th>
						@foreach ($events as $key =>  $event)
							<th colspan="8">
								{{ $event->name }}
							</th>
							@if ( ($key + 1) == 3  )
								{{-- para la semifinal --}}
								<th></th>
							@endif
						@endforeach
							<th colspan="2"></th>
						</tr>
						<tr>
							<th></th>
							@for ($i = 0; $i < count($events) ; $i++)
								@foreach ($judges as $key =>  $judge)
									<th class="text-center"> Juez #{{($key+1)}} </th>
								@endforeach
								<th class="text-center">Suma</th>
								<th class="text-center">Prom</th>
								@if ( ($i +1 ) == 3)
									<th class="text-center">Semifinal</th>
								@endif
							@endfor
							<th class="text-center">Sum Final</th>
							<th class="text-center">Promedio Ge.</th>
						</tr>
				</thead>
				<tbody>
					@foreach (App\Score::getFullScore() as $element)
						<tr>
							<td><b>{{ $element->canton }}</b></td>
							@for ($i = 0; $i < count($events) ; $i++)
								@for ($j = 0; $j < count($judges) ; $j++)
								@php $score = "score_ju_".($j+1)."_event".($i+1); @endphp
								<td class="text-center">{{$element->$score}}</td>
								@endfor
								@php $resultevent = "sum_event_".($i+1);  @endphp
								@php $promtevent = "prom_event_".($i+1);  @endphp
								<td class="text-center">{{$element->$resultevent}}</td>
								<td class="text-center">{{$element->$promtevent}}</td>
								@if ( ($i +1 ) == 3)
									<td class="text-center">{{$element->semifinal}}</td>
								@endif
							@endfor
							<td class="text-center">{{$element->gran_total}}</td>
							<td class="text-center">{{$element->promedio_final}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<hr>
			<div class="col-md-2 col-md-offset-6">
				<a type="button" class="btn btn-default" href="{{ route('print',['type'=>'full']) }}" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
			</div>
		</div>
	</div>
</div>
@endsection
