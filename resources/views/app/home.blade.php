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
                    <div class="col-md-4 col-md-offset-4 text-center">
                        <a href="@can('vote'){{ route('vote',['evento'=>$current_event->generateSlug()]) }}@endcan @cannot('vote')#@endcannot" title="" class="event-icon  @cannot('vote') disabled @endcannot">
                            @can('vote')
                                <img src="{{ asset($current_event->getImg()) }}" alt="">
                            @endcan
                            @cannot('vote')
                                <img src="{{ asset($current_event->getImg(true)) }}" alt="">
                            @endcannot
                            <span>{{$current_event->name}}</span>
                        </a>
                    </div>
{{-- 
                    @can('vote',$current_event)
                    <div class="col-md-4 text-center">
                        <a href="{{ route('vote',['evento'=>'vestido_noche']) }}" title="" class="event-icon">
                            <img src="{{ asset('images/vestido_noche.png') }}" alt="">
                            <span>Traje de Noche</span>
                        </a>
                    </div>
                    @endcan

                    @can('vote',$current_event)
                    <div class="col-md-4 text-center">
                        <a href="{{ route('vote',['evento'=>'vestido_traje_banio']) }}" title="" class="event-icon">
                            <img src="{{ asset('images/vestido_traje_banio.png') }}" alt="">
                            <span>Traje de Baño</span>
                        </a>
                    </div>
                    @endcan

                    @can('vote',$current_event)
                    <div class="col-md-4 text-center">
                        <a href="{{ route('vote',['evento'=>'ronda_preguntas']) }}" title="" class="event-icon">
                            <img src="{{ asset('images/ronda_preguntas.png') }}" alt="">
                            <span>Ronda de Preguntas</span>
                        </a>
                    </div>
                    @endcan

                    @can('vote',$current_event) 
                    <div class="col-md-4 text-center">
                        <a href="{{ route('vote',['evento'=>'ronda_preguntas']) }}" title="" class="event-icon">
                            <img src="{{ asset('images/ronda_preguntas.png') }}" alt="">
                            <span>Desempate</span>
                        </a>
                    </div>
                    @endcan --}} 
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
