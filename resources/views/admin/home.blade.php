@extends('layouts.admin')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">Admin</div>

    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        Hola Admin
    </div>
</div>
@endsection
