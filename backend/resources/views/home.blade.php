@extends('layouts.app')

@section('title', 'HANDY SOLUTIONS - Inicio')

@section('content')
<section class="hero bg-light rounded-3 p-5 mb-5 text-center">
    <h1 class="display-4 fw-bold text-primary">HANDY SOLUTIONS</h1>
    <p class="lead">Soluciones profesionales de reparación para tu hogar</p>
    <p class="text-muted">Plomería, electricidad, carpintería, pintura, albañilería e impermeabilización</p>
    <a href="{{ route('solicitudes.create') }}" class="btn btn-primary btn-lg mt-3">
        <i class="bi bi-tools"></i> Solicitar servicio
    </a>
</section>

<section class="mb-5">
    <h2 class="h3 mb-4">Nuestros servicios</h2>
    <div class="row g-4">
        @foreach($servicios as $servicio)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                @if($servicio->imagen)
                    <img src="{{ asset('storage/' . $servicio->imagen) }}" class="card-img-top" alt="{{ $servicio->nombre }}" style="height:180px;object-fit:cover">
                @else
                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height:180px">
                        <i class="bi bi-tools display-4 text-white"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $servicio->nombre }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($servicio->descripcion, 80) }}</p>
                    <a href="{{ route('servicios.show', $servicio->slug) }}" class="btn btn-outline-primary btn-sm">Ver más</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

@if($galeria->isNotEmpty())
<section class="mb-5">
    <h2 class="h3 mb-4">Trabajos realizados</h2>
    <div class="row g-3">
        @foreach($galeria->take(6) as $item)
        <div class="col-6 col-md-4">
            <img src="{{ asset('storage/' . $item->imagen) }}" alt="{{ $item->titulo }}" class="img-fluid rounded shadow-sm" style="height:180px;width:100%;object-fit:cover">
        </div>
        @endforeach
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('galeria') }}" class="btn btn-outline-secondary">Ver galería</a>
    </div>
</section>
@endif
@endsection
