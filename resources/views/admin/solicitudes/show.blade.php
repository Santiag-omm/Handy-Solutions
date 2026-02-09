@extends('layouts.admin')

@section('title', 'Solicitud ' . $solicitud->folio)

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.solicitudes.index') }}">Solicitudes</a></li>
        <li class="breadcrumb-item active">{{ $solicitud->folio }}</li>
    </ol>
</nav>
<h1 class="mb-4">{{ $solicitud->folio }}</h1>
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Cliente:</strong> {{ $solicitud->user->name }} ({{ $solicitud->user->email }})</p>
                <p><strong>Servicio:</strong> {{ $solicitud->servicio->nombre }}</p>
                <p><strong>Dirección:</strong> {{ $solicitud->direccion }}</p>
                <p><strong>Urgencia:</strong> {{ $solicitud->urgencia }}</p>
                <p><strong>Estado:</strong> <span class="badge bg-secondary">{{ $solicitud->estado }}</span></p>
                @if($solicitud->descripcion_problema)
                    <p><strong>Descripción:</strong> {{ $solicitud->descripcion_problema }}</p>
                @endif
            </div>
        </div>
        @if(in_array($solicitud->estado, ['pendiente', 'validada']))
        <div class="card mb-3">
            <div class="card-body">
                <h6>Acciones</h6>
                <form action="{{ route('admin.solicitudes.validar', $solicitud) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Validar</button>
                </form>
                <form action="{{ route('admin.solicitudes.rechazar', $solicitud) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="text" name="observaciones_admin" class="form-control form-control-sm d-inline-block w-auto" placeholder="Motivo (opcional)">
                    <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                </form>
            </div>
        </div>
        @endif
        @if(in_array($solicitud->estado, ['validada', 'cotizada']) && !$solicitud->ordenTrabajoActual)
        <div class="card mb-3">
            <div class="card-body">
                <h6>Asignar técnico</h6>
                <a href="{{ route('admin.ordenes.create', $solicitud) }}" class="btn btn-primary">Crear orden y asignar técnico</a>
            </div>
        </div>
        @endif
        @if($solicitud->ordenTrabajoActual)
        <div class="card mb-3">
            <div class="card-body">
                <h6>Orden de trabajo</h6>
                <p><strong>Código:</strong> {{ $solicitud->ordenTrabajoActual->codigo }}</p>
                <p><strong>Técnico:</strong> {{ $solicitud->ordenTrabajoActual->tecnico->user->name }}</p>
                <a href="{{ route('admin.ordenes.show', $solicitud->ordenTrabajoActual) }}" class="btn btn-sm btn-outline-primary">Ver orden</a>
            </div>
        </div>
        @endif
    </div>
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">Cotización</div>
            <div class="card-body">
                @if($solicitud->cotizacionActual)
                    <p class="h4">${{ number_format($solicitud->cotizacionActual->monto, 2) }}</p>
                    <p class="small text-muted">{{ $solicitud->cotizacionActual->observaciones }}</p>
                @endif
                <form action="{{ route('admin.solicitudes.cotizar', $solicitud) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <input type="number" name="monto" class="form-control form-control-sm" step="0.01" placeholder="Monto" value="{{ $solicitud->cotizacionActual?->monto }}">
                    </div>
                    <div class="mb-2">
                        <textarea name="observaciones" class="form-control form-control-sm" rows="2" placeholder="Observaciones"></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Actualizar cotización</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
