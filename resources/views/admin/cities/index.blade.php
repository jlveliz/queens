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
	   		@if (Session::has('mensaje'))
	   		    <div class="alert alert-dismissible @if(Session::get('tipo_mensaje') == 'success') alert-info  @endif @if(Session::get('tipo_mensaje') == 'error') alert-danger  @endif" role="alert">
	   		        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	   		          {{session('mensaje')}}
	   		    </div>
	   		    <div class="clearfix"></div>
	   		@endif
	   		<table class="table table-bordered">
	   			<thead>
	   				<tr>
	   					<th class="text-center">N°</th>
	   					<th class="text-center">Nombre</th>
	   					<th class="text-center">Estado</th>
	   					<th class="text-center">Acción</th>
	   				</tr>
	   			</thead>
	   			<tbody>
	   				@if (count($cities) > 0)
	   					@foreach ($cities as $key => $city)
			   				<tr>
								<td> {{$key+1}} </td>   
								<td>{{$city->name}}</td>
			   					<td>@if($city->state == 1) <b class="text-success">Activo</b> @else <b class="text-danger"> Inactivo</b> @endif</td>
			   					<td>
			   						<a class="btn btn-primary btn-sm" href="{{ url('admin/cities/'.$city->id.'/edit') }}">Editar</a>
			   						<button class="btn btn-danger btn-sm delete-el" type="button" class="">Eliminar</button>
			   						<form action="{{ url('admin/cities/'.$city->id) }}" style="display: none" method="POST">
			   							<input type="hidden" name="_token" value="{{ csrf_token() }}">
         								<input type="hidden" name="_method" value="DELETE">
			   						</form>
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

