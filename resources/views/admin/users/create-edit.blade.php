@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="panel panel-default">
	  <div class="panel-heading">Usuarios</div>
	   <p class="subtitle">@if(isset($user)) Editar Usuario @else Crear Usuario @endif</p>
	   <div class="panel-body">	   		
	   		@if (Session::has('mensaje'))
	   		    <div class="alert alert-disuserible @if(Session::get('tipo_mensaje') == 'success') alert-info  @endif @if(Session::get('tipo_mensaje') == 'error') alert-danger  @endif" role="alert">
	   		        <button type="button" class="close" data-disuser="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	   		          {{session('mensaje')}}
	   		    </div>
	   		    <div class="clearfix"></div>
	   		@endif

	   		<form action="@if(isset($user) && $user->id){{ url('admin/users/'.$user->id) }}@else{{ url('admin/users') }}@endif" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				@if (isset($user) && $user->id)
					<input type="hidden" name="_method" value="PUT">
				@endif
				<div class="row">
					
					<div class="form-group col-md-3 col-sm-3 col-xs-12 @if($errors->has('username')) has-error @endif">
						<label class="control-label">Usuario </label>
						<input type="text" class="form-control" name="username" value="@if(isset($user)){{$user->username}}@else{{old('username')}}@endif" autofocus>
						@if ($errors->has('username')) <p class="help-block">{{ $errors->first('username') }}</p> @endif
					</div>

					<div class="form-group col-md-3 col-sm-3 col-xs-12 @if($errors->has('password')) has-error @endif">
						<label class="control-label">Contraseña </label>
						<input type="text" class="form-control" name="password" value="">
						@if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
					</div>

					<div class="form-group col-md-2 col-sm-2 col-xs-12 @if($errors->has('role')) has-error @endif">
						<label class="control-label">Rol</label>
						<select class="form-control" name="role">
							<option value="admin" @if( (isset($user) && $user->role == 'admin') || old('role') == 'admin' ) selected @endif>Admin</option>
							<option value="juez" @if( (isset($user) && $user->role == 'juez') || old('role') == 'juez' ) selected @endif>Juez</option>
							<option value="notario" @if( (isset($user) && $user->role == 'notario') || old('role') == 'notario' ) selected @endif>Notario</option>
						</select>
						@if ($errors->has('role')) <p class="help-block">{{ $errors->first('role') }}</p> @endif
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="form-group col-md-12 col-sm-12 col-xs-12">
						<a href="{{ url('admin/users/') }}" class="btn btn-primary">Cancelar</a>
		                <button type="submit" class="btn btn-success" id="save">Guardar</button>
				    </div>
				</div>
			</form>
	   </div>
	</div>
</div>
@endsection()



@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-file-input/fileinput.min.css') }}">
@endsection()
@section('js')
<script src="{{ asset('js/bootstrap-file-input/fileinput.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$("#photos").fileinput({
		language : 'es',
		theme:'fa',
		allowedFileTypes: ['image'],
		showUpload: false,
		minFileCount: 1,
		maxFileCount: 3,
		autoReplace:true,
		overwriteInitial:false,
		showUploadedThumbs: true,
		initialPreviewAsData: true,
		initialPreviewFileType: 'image',
		showRemove: true,
		@if (isset($user))
		initialPreview : [
			'{{config('app.url').'/'.$user->photos}}',
		],
		initialPreviewConfig: [
    		{ caption : '{{$user->photos}}', url: '{{asset('$user->photos')}}', id: {{$user->id}} }
    	]
		@endif
	});
</script>
@endsection()