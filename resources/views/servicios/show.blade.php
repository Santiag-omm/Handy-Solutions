@extends('layouts.app')

@section('title', $servicio->nombre . ' - HANDY SOLUTIONS')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('servicios.index') }}">Servicios</a></li>
        <li class="breadcrumb-item active">{{ $servicio->nombre }}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-8">
        @if($servicio->imagen)
            <img src="{{ asset('storage/' . $servicio->imagen) }}" class="img-fluid rounded mb-3" alt="{{ $servicio->nombre }}">
        @endif
        <h1>{{ $servicio->nombre }}</h1>
        <p class="text-muted">{{ $servicio->descripcion }}</p>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5>Precio base</h5>
                <p class="h4 text-primary">${{ number_format($servicio->precio_base, 0) }}</p>
                <p class="small text-muted">Cotización final según valoración in situ</p>
                @auth
                    <a href="{{ route('solicitudes.create') }}?servicio={{ $servicio->id }}" class="btn btn-primary w-100">Solicitar este servicio</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary w-100">Iniciar sesión para solicitar</a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
