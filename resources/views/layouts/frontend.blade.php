<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} {{ date('Y') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
	<div class="login_background">
    @if (Request::path() == '/')
		  <p>&nbsp;</p>
    @endif
		@yield('content')
	</div>
	<script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/jquery.bgswitcher.js') }}" type="text/javascript" ></script>
    <script type="text/javascript" >
         $(document).ready(function() {
                $(".login_background").bgswitcher({
                  images: ["{{ asset('images/01.jpg')}}","{{asset('images/02.jpg')}}","{{asset('images/03.jpg')}}"],
                  loop:true,
                  effect: "fade", 
                  interval: 8000, 
                  shuffle: false, 
                  duration: 8000, 
                  easing: "swing"    
                });
              });
    </script>
	@yield('js')
</body>
