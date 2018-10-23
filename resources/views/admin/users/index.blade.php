@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="panel panel-default">
	  <div class="panel-heading">Usuarios</div>
	   <div class="panel-body">
	   		<caption>
	   			Listado
	   			<a class="pull-right btn btn-primary" href="{{ url('/admin/users/create') }}" title="Crear Candidata"><i class="fa fa-plus"></i> Crear</a>
	   		</caption>
	   		<table class="table table-bordered">
	   			<thead>
	   				<tr>
	   					<th class="text-center col-md-1">N°</th>
	   					<th class="text-center col-md-4">Usuario</th>
	   					<th class="text-center col-md-4">Rol</th>
	   					<th class="text-center col-md-2">Acción</th>
	   				</tr>
	   			</thead>
	   			<tbody>
	   				@if (count($users) > 0)
	   					@foreach ($users as $idx =>  $user)
			   				<tr>
			   					<td>{{ ($idx + 1) }}</td>
			   					<td>{{$user->username}}</td>
			   					<td>{{$user->role}}</td>
			   					<td>
			   						<a class="btn btn-primary btn-sm" href="{{ url('admin/users/'.$user->id.'/edit') }}">Editar</a>
				   					<button class="btn btn-danger btn-sm delete-el" type="button" class="">Eliminar</button>
				   					<form action="{{ url('admin/users/'.$user->id) }}" style="display: none" method="POST">
			   							<input type="hidden" name="_token" value="{{ csrf_token() }}">
	     								<input type="hidden" name="_method" value="DELETE">
				   					</form>
			   					</td>
			   				</tr>
	   					@endforeach
	   				@else
	   					<tr>
	   						<td colspan="4" rowspan="" headers=""><p class="text-muted text-center">No existen Usuarios a Mostrar</p> </td>
	   					</tr>
	   				@endif
	   			</tbody>
	   		</table>
	   </div>
	</div>
</div>
@endsection