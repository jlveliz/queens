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
		margin: 0 auto;
		font-size: 13pt;
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
			@foreach ($data as $key =>  $score)
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
	</div>
</body>
</html>