@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="panel panel-default">
	  <div class="panel-heading">Ciudades</div>
	   <p class="subtitle">@if(isset($city)) Editar Ciudad @else Crear Ciudad @endif</p>
	   <div class="panel-body">	   		
	   		@if (Session::has('mensaje'))
	   		    <div class="alert alert-dismissible @if(Session::get('tipo_mensaje') == 'success') alert-info  @endif @if(Session::get('tipo_mensaje') == 'error') alert-danger  @endif" role="alert">
	   		        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	   		          {{session('mensaje')}}
	   		    </div>
	   		    <div class="clearfix"></div>
	   		@endif

	   		<form action="{{ url('admin/cities') }}" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="row">
					<div class="form-group col-md-3 col-sm-3 col-xs-12 @if($errors->has('name')) has-error @endif">
						<label class="control-label">Nombre </label>
						<input type="text" class="form-control" name="name" value="@if(isset($city)) {{$city->name}} @else{{ old('name')}} @endif" autofocus>
						@if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
					</div>

					<div class="form-group col-md-3 col-sm-3 col-xs-12 @if($errors->has('state')) has-error @endif">
						<label class="control-label">Estado </label>
							{{$city->state}}
						<select class="form-control" name="state">
							<option value="1" @if( (isset($city) && $city->state == '1' ) || (old('state') == 1) ) selected @endif>Activo</option>
							<option value="0"  @if( (isset($city) && $city->state == '0' ) || (old('state') == 0) ) selected @endif>Inactivo</option>
						</select>
						@if ($errors->has('state')) <p class="help-block">{{ $errors->first('state') }}</p> @endif
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="form-group col-md-12 col-sm-12 col-xs-12">
						<a href="{{ url('admin/cities/') }}" class="btn btn-primary">Cancelar</a>
		                <button type="submit" class="btn btn-success" id="save">Guardar</button>
				    </div>
				</div>
			</form>
	   </div>
	</div>
</div>
@endsection