@extends('layouts.app')

@section('title', 'Solicitud ' . $solicitud->folio)

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Solicitud {{ $solicitud->folio }}</li>
    </ol>
</nav>
<h1 class="mb-4">Solicitud {{ $solicitud->folio }}</h1>
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <p><strong>Estado:</strong> <span class="badge bg-secondary">{{ ucfirst($solicitud->estado) }}</span></p>
                <p><strong>Servicio:</strong> {{ $solicitud->servicio->nombre }}</p>
                <p><strong>Dirección:</strong> {{ $solicitud->direccion }}</p>
                <p><strong>Urgencia:</strong> {{ ucfirst($solicitud->urgencia) }}</p>
                @if($solicitud->fecha_deseada)
                    <p><strong>Fecha deseada:</strong> {{ $solicitud->fecha_deseada->format('d/m/Y') }}</p>
                @endif
                @if($solicitud->descripcion_problema)
                    <p><strong>Descripción:</strong> {{ $solicitud->descripcion_problema }}</p>
                @endif
            </div>
        </div>
        @if($solicitud->fotos)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6>Fotos</h6>
                    <div class="row g-2">
                        @foreach($solicitud->fotos as $foto)
                            <div class="col-4"><img src="{{ asset('storage/' . $foto) }}" class="img-fluid rounded" alt="Foto"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Cotización</h5>
                @if($solicitud->cotizacionActual)
                    <p class="h4 text-primary">${{ number_format($solicitud->cotizacionActual->monto, 2) }}</p>
                    <p class="small text-muted">{{ $solicitud->cotizacionActual->observaciones }}</p>
                @else
                    <p class="text-muted">Pendiente de cotización</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
