@extends('layouts.app')

@section('title', 'Servicios - HANDY SOLUTIONS')

@section('content')
<h1 class="mb-4">Nuestros servicios</h1>
<div class="row g-4">
    @foreach($servicios as $servicio)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
            @if($servicio->imagen)
                <img src="{{ asset('storage/' . $servicio->imagen) }}" class="card-img-top" alt="{{ $servicio->nombre }}" style="height:200px;object-fit:cover">
            @else
                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height:200px">
                    <i class="bi bi-tools display-4 text-white"></i>
                </div>
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $servicio->nombre }}</h5>
                <p class="card-text">{{ Str::limit($servicio->descripcion, 120) }}</p>
                <p class="text-primary fw-bold">Desde ${{ number_format($servicio->precio_base, 0) }}</p>
                <a href="{{ route('servicios.show', $servicio->slug) }}" class="btn btn-primary">Ver detalle</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
