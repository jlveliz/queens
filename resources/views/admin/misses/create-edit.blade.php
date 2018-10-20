@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="panel panel-default">
	  <div class="panel-heading">Candidatas</div>
	   <p class="subtitle">@if(isset($miss)) Editar Candidata @else Crear Candidata @endif</p>
	   <div class="panel-body">	   		
	   		@if (Session::has('mensaje'))
	   		    <div class="alert alert-dismissible @if(Session::get('tipo_mensaje') == 'success') alert-info  @endif @if(Session::get('tipo_mensaje') == 'error') alert-danger  @endif" role="alert">
	   		        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	   		          {{session('mensaje')}}
	   		    </div>
	   		    <div class="clearfix"></div>
	   		@endif

	   		<form action="@if(isset($miss) && $miss->id){{ url('admin/misses/'.$miss->id) }}@else{{ url('admin/misses') }}@endif" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				@if (isset($miss) && $miss->id)
					<input type="hidden" name="_method" value="PUT">
				@endif
				<div class="row">
					
					<div class="form-group col-md-3 col-sm-3 col-xs-12 @if($errors->has('city_id')) has-error @endif">
						<label class="control-label">Cantón </label>
						<select class="form-control" name="city_id">
							@foreach ($cities as $city)
							<option value="{{$city->id}}" @if( (isset($miss) && $miss->city_id == $city->id ) || (old('city_id') == $city->id) ) selected @endif>{{$city->name}}</option>
							@endforeach
						</select>
						@if ($errors->has('city_id')) <p class="help-block">{{ $errors->first('city_id') }}</p> @endif
					</div>

					<div class="form-group col-md-3 col-sm-3 col-xs-12 @if($errors->has('name')) has-error @endif">
						<label class="control-label">Nombre </label>
						<input type="text" class="form-control" name="name" value="@if(isset($miss)){{$miss->name}}@else{{old('name')}}@endif" autofocus>
						@if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
					</div>

					<div class="form-group col-md-3 col-sm-3 col-xs-12 @if($errors->has('last_name')) has-error @endif">
						<label class="control-label">Apellido </label>
						<input type="text" class="form-control" name="last_name" value="@if(isset($miss)){{$miss->last_name}}@else{{old('last_name')}}@endif">
						@if ($errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
					</div>

					<div class="form-group col-md-2 col-sm-2 col-xs-12 @if($errors->has('age')) has-error @endif">
						<label class="control-label">Edad</label>
						<select class="form-control" name="age">
							@for ($i = 15; $i < 30; $i++)
								<option value="{{$i}}">{{$i}} Años</option>
							@endfor
						</select>
						@if ($errors->has('age')) <p class="help-block">{{ $errors->first('age') }}</p> @endif
					</div>

					<div class="form-group col-md-3 col-sm-3 col-xs-12 @if($errors->has('height')) has-error @endif">
						<label class="control-label">Estatura </label>
						<input type="text" class="form-control" name="height" value="@if(isset($miss)){{$miss->height}}@else{{old('height')}}@endif">
						@if ($errors->has('height')) <p class="help-block">{{ $errors->first('height') }}</p> @endif
					</div>

					<div class="form-group col-md-3 col-sm-3 col-xs-12 @if($errors->has('measurements')) has-error @endif">
						<label class="control-label">Medidas </label>
						<input type="text" class="form-control" name="measurements" value="@if(isset($miss)){{$miss->measurements}}@else{{old('measurements')}}@endif">
						@if ($errors->has('measurements')) <p class="help-block">{{ $errors->first('measurements') }}</p> @endif
					</div>

					<div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('activities')) has-error @endif">
						<label class="control-label">Actividades </label>
						<textarea class="form-control" name="activities">@if(isset($miss)){{$miss->activities}}@else{{old('activities')}}@endif</textarea>
						@if ($errors->has('activities')) <p class="help-block">{{ $errors->first('activities') }}</p>@endif
					</div>

					<div class="form-group col-md-6 col-sm-6 col-xs-12 @if($errors->has('hobbies')) has-error @endif">
						<label class="control-label">Hobbies </label>
						<textarea class="form-control" name="hobbies">@if(isset($miss)){{$miss->activities}}@else{{old('activities')}}@endif</textarea>
						@if ($errors->has('activities')) <p class="help-block">{{ $errors->first('activities') }}</p>@endif
					</div>

					<div class="form-group col-md-3 col-sm-3 col-xs-12 @if($errors->has('state')) has-error @endif">
						<label class="control-label">Estado </label>
						<select class="form-control" name="state">
							<option value="1" @if( (isset($miss) && $miss->state == '1' ) || (old('state') == '1') ) selected @endif>Activo</option>
							<option value="0"  @if( (isset($miss) && $miss->state == '0' ) || (old('state') == '0') ) selected @endif>Inactivo</option>
						</select>
						@if ($errors->has('state')) <p class="help-block">{{ $errors->first('state') }}</p> @endif
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
					<label class="control-label">Foto</label>
					<input type="file" name="photos[]" id="photos" multiple accept="image/*">
					@if ($errors->has('photos')) <p class="help-block">{{ $errors->first('photos') }}</p> @endif
				</div>
				</div>
				<hr>
				<div class="row">
					<div class="form-group col-md-12 col-sm-12 col-xs-12">
						<a href="{{ url('admin/misses/') }}" class="btn btn-primary">Cancelar</a>
		                <button type="submit" class="btn btn-success" id="save">Guardar</button>
				    </div>
				</div>
			</form>
	   </div>
	</div>
@endsection



@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-file-input/fileinput.min.css') }}">
@endsection