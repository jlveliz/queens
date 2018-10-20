@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="panel panel-default">
	  <div class="panel-heading">Candidatas</div>
	   <div class="panel-body">
	   		<caption>
	   			Listado
	   			<a class="pull-right btn btn-primary" href="{{ url('/admin/misses/create') }}" title="Crear Candidata"><i class="fa fa-plus"></i> Crear</a>
	   		</caption>
	   		<table class="table table-bordered">
	   			<thead>
	   				<tr>
	   					<th class="text-center">Cantón</th>
	   					<th class="text-center">Nombre</th>
	   					<th class="text-center">Estado</th>
	   					<th class="text-center">Acción</th>
	   				</tr>
	   			</thead>
	   			<tbody>
	   				@if (count($misses) > 0)
		   				<tr>
		   					<td>{{$misses->city}}</td>
		   					<td>{{$misses->name}} {{$misses->last_name}}</td>
		   					<td>{{$misses->state}}</td>
		   					<td>
		   						<a class="btn btn-primary btn-sm" href="{{ url('admin/cities/'.$city->id.'/edit') }}">Editar</a>
			   					<button class="btn btn-danger btn-sm delete-el" type="button" class="">Eliminar</button>
			   					<form action="{{ url('admin/cities/'.$city->id) }}" style="display: none" method="POST">
		   							<input type="hidden" name="_token" value="{{ csrf_token() }}">
     								<input type="hidden" name="_method" value="DELETE">
			   					</form>
		   					</td>
		   				</tr>
	   				@else
	   					<tr>
	   						<td colspan="3" rowspan="" headers=""><p class="text-muted text-center">No existen Candidatas a Mostrar</p> </td>
	   					</tr>
	   				@endif
	   			</tbody>
	   		</table>
	   </div>
	</div>
</div>
@endsection