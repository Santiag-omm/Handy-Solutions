@extends('layouts.admin')

@section('title', 'Orden ' . $orden->codigo)

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.ordenes.index') }}">Órdenes</a></li>
        <li class="breadcrumb-item active">{{ $orden->codigo }}</li>
    </ol>
</nav>
<h1 class="mb-4">{{ $orden->codigo }}</h1>
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Estado:</strong> <span class="badge bg-secondary">{{ $orden->estado }}</span></p>
                <p><strong>Solicitud:</strong> <a href="{{ route('admin.solicitudes.show', $orden->solicitud) }}">{{ $orden->solicitud->folio }}</a></p>
                <p><strong>Cliente:</strong> {{ $orden->solicitud->user->name }}</p>
                <p><strong>Técnico:</strong> {{ $orden->tecnico->user->name }}</p>
                <p><strong>Fecha asignada:</strong> {{ $orden->fecha_asignada?->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">Cambiar estado</div>
            <div class="card-body">
                <form action="{{ route('admin.ordenes.estado', $orden) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <select name="estado" class="form-select form-select-sm d-inline-block w-auto">
                        @foreach(['asignada','en_camino','en_proceso','completada','cancelada'] as $e)
                            <option value="{{ $e }}" {{ $orden->estado === $e ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$e)) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">Registrar pago</div>
            <div class="card-body">
                <form action="{{ route('admin.pagos.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="orden_trabajo_id" value="{{ $orden->id }}">
                    <div class="row g-2 mb-2">
                        <div class="col">
                            <input type="number" name="monto" class="form-control form-control-sm" step="0.01" placeholder="Monto" required>
                        </div>
                        <div class="col">
                            <select name="metodo" class="form-select form-select-sm">
                                <option value="efectivo">Efectivo</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="tarjeta">Tarjeta</option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" name="referencia" class="form-control form-control-sm" placeholder="Referencia">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">Registrar pago</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">Pagos</div>
            <ul class="list-group list-group-flush">
                @forelse($orden->pagos as $pago)
                <li class="list-group-item d-flex justify-content-between">
                    <span>${{ number_format($pago->monto, 2) }} ({{ $pago->metodo }})</span>
                    <span class="badge bg-{{ $pago->estado === 'completado' ? 'success' : 'secondary' }}">{{ $pago->estado }}</span>
                </li>
                @empty
                <li class="list-group-item text-muted">Sin pagos registrados</li>
                @endforelse
            </ul>
        </div>
        @if($orden->resena)
        <div class="card">
            <div class="card-header">Reseña del cliente</div>
            <div class="card-body">
                <p class="mb-0">{{ $orden->resena->calificacion }}/5 - {{ $orden->resena->comentario }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
