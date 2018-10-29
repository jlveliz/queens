<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>
	body {
		margin: 0;
		padding: 0
	} 
	table {
		font-size: 9pt;
		border:1px solid #cdcdcd;
		border-spacing: 0;
    	border-collapse: all;
	}
	table th, table td {
		border: 1px solid #cdcdcd;
		padding: 0px;
		margin: 0px;

	}
	.page-break {
	    page-break-after: always;
	}

	.text-center {
		text-align:center;
	}

	.title {
		text-transform: uppercase;
		font-size: 12pt
	}
	.container {
		margin: 0 auto;
	}

	.header {
		font-size: 22pt
	}
	</style>
</head>
<body>
	<div class="container">
		<h1 class="text-center header">GOBIERNO PROVINCIAL DEL GUAYAS <br> {{ strtoupper( config('app.name') .' - '. date('Y') )}}</h1>
		<h1 class="text-center title">{{$streamName}}</h1>
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
				@foreach ($data as $element)
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
	</div>
</body>
</html>