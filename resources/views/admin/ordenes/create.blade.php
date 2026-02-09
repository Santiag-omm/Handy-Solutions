@extends('layouts.admin')

@section('title', 'Asignar técnico')

@section('content')
<h1 class="mb-4">Asignar técnico a {{ $solicitud->folio }}</h1>
<div class="card">
    <div class="card-body">
        <p><strong>Servicio:</strong> {{ $solicitud->servicio->nombre }}</p>
        <p><strong>Cliente:</strong> {{ $solicitud->user->name }}</p>
        <p><strong>Cotización:</strong> ${{ number_format($solicitud->cotizacionActual?->monto ?? 0, 2) }}</p>
        <form action="{{ route('admin.ordenes.store') }}" method="POST">
            @csrf
            <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">
            <input type="hidden" name="cotizacion_id" value="{{ $solicitud->cotizacionActual?->id }}">
            <div class="mb-3">
                <label class="form-label">Técnico *</label>
                <select name="tecnico_id" class="form-select" required>
                    <option value="">Selecciona...</option>
                    @foreach($tecnicos as $t)
                        <option value="{{ $t->id }}">{{ $t->user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha asignada</label>
                <input type="datetime-local" name="fecha_asignada" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
            </div>
            <button type="submit" class="btn btn-primary">Crear orden y asignar</button>
            <a href="{{ route('admin.solicitudes.show', $solicitud) }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
