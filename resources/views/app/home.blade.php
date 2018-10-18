@extends('layouts.frontend')

@section('content')
<div class="container-index">
    <div class="vertical-center inner-container col-md-10 col-md-offset-1">
        <img src="{{ asset('images/logo.png') }}" style="width: 70%;display: block;margin:0 auto" class="img-responsive text-center" alt="">
        <h1 class="text-center"> {{config('app.name')}} - {{date('Y')}}  </h1>

        <div class="panel panel-default">
            <div class="panel-heading text-center" style="font-size: 20px"><b>Seleccione un evento para continuar</b>
                <br>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Salir</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        @can('vote',Auth::user())
                        <a href="{{ route('vote',['evento'=>'traje_tipico']) }}" title="" class="event-icon">
                            <img src="{{ asset('images/traje_tipico.png') }}" alt="">
                            <span>Traje Típico</span>
                        </a>
                        @endcan

                        @cannot('vote',Auth::user())
                        <a href="" title="" class="event-icon disabled">
                            <img src="{{ asset('images/traje_tipico.png') }}" alt="">
                            <span>Traje Típico</span>
                        </a>
                        @endcannot
                    </div>

                    <div class="col-md-4 text-center">
                        @can('vote',Auth::user())
                        <a href="{{ route('vote',['evento'=>'vestido_noche']) }}" title="" class="event-icon">
                            <img src="{{ asset('images/vestido_noche.png') }}" alt="">
                            <span>Traje de Noche</span>
                        </a>
                        @endcan

                        @cannot('vote',Auth::user())
                        <a href="#" title="" class="event-icon disabled">
                            <img src="{{ asset('images/vestido_noche.png') }}" alt="">
                            <span>Traje de Noche</span>
                        </a>
                        @endcannot
                    </div>

                    <div class="col-md-4 text-center">
                        @can('vote',Auth::user())
                        <a href="{{ route('vote',['evento'=>'vestido_traje_banio']) }}" title="" class="event-icon">
                            <img src="{{ asset('images/vestido_traje_banio.png') }}" alt="">
                            <span>Traje de Baño</span>
                        </a>
                         @endcan

                        @cannot('vote',Auth::user())
                        <a href="#" title="" class="event-icon disabled">
                            <img src="{{ asset('images/vestido_traje_banio.png') }}" alt="">
                            <span>Traje de Baño</span>
                        </a>
                         @endcannot
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 text-center">
                        <a href="@can('vote',Auth::user()) {{ route('vote',['evento'=>'ronda_preguntas']) }} @endcan @cannot('vote',Auth::user()) # @endcannot" title="" class="event-icon @cannot('vote',Auth::user()) disabled @endcannot">
                             <img src="{{ asset('images/ronda_preguntas.png') }}" alt="">
                            <span>Ronda de Preguntas</span>
                        </a>
                    </div>

                    <div class="col-md-6 text-center">
                        <a href="@can('vote',Auth::user()) {{ route('vote',['evento'=>'ronda_preguntas']) }} @endcan @cannot('vote',Auth::user()) # @endcannot" title="" class="event-icon @cannot('vote',Auth::user()) disabled @endcannot">
                             <img src="{{ asset('images/ronda_preguntas.png') }}" alt="">
                            <span>Desempate</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
