@extends('layouts.frontend')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
@endsection()

@section('content')
<div id="wrapper">
      <div id="login" class="animated form bounceIn">
        <section class="login_content">
          <img src="{{ asset('images/logo_reinas.png') }}" style="width: 70%;display: block;margin:0 auto" class="img-responsive text-center" alt="">
          <form method="post" action="{{ route('dologin') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h1>{{config('app.name')}}</h1>
            <h3>Ingreso</h3>
            @if (count($errors) > 0)
              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    @foreach ($errors->all() as $error)
                      <strong>{!!$error!!}</strong> <br>
                    @endforeach
                  </div>
            @endif
              <div>
              <input type="text" class="form-control" placeholder="Usuario" name="username" id="username" required="" autocomplete="false" autofocus />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Clave" name="password" id="password" required="" />
            </div>
            <div>
              <button type="submit" class="btn btn-block btn-submit">Ingresar</button>
              
            </div>
            <div class="clearfix"></div>
            <div class="separator">
              <div class="clearfix"></div>
              <br />
              <div class="footer-login">
                <h4><i class="fa fa-cog"></i> {{config('app.name')}}</h4>

                <p class="copyright">©{{date('Y')}} Todos los derechos reservados. Una aplicación de <b>Gobierno Provincial del Guayas.</b></p>
              </div>
            </div>
          </form>
          <!-- form -->
        </section>
        <!-- content -->
      </div>
</div>

@endsection
