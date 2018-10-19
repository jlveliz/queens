@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="panel panel-default">
	  <div class="panel-heading">Ciudades</div>
	   <div class="panel-body">
	   		<caption>
	   			Listado
	   			<a class="pull-right btn btn-primary" href="{{ url('/admin/cities/create') }}" title="Crear Ciudad"><i class="fa fa-plus"></i> Crear</a>
	   		</caption>
	   		<table class="table table-bordered">
	   			<thead>
	   				<tr>
	   					<th class="text-center">Nombre</th>
	   					<th class="text-center">Acción</th>
	   				</tr>
	   			</thead>
	   			<tbody>
	   				@if (count($cities) > 0)
	   					@foreach ($cities as $city)
			   				<tr>
			   					<td>{{$city->name}}</td>
			   					<td>
			   						<a href="">Editar</a>
			   						<button type="button" class="delete-el">Eliminar</button>
			   					</td>
			   				</tr>
	   					@endforeach
	   				@else
	   					<tr>
	   						<td colspan="3" rowspan="" headers=""><p class="text-muted text-center">No existen Cantones a Mostrar</p> </td>
	   					</tr>
	   				@endif
	   			</tbody>
	   		</table>
	   </div>
	</div>
</div>
@endsection()