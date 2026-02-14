@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 mb-0">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.contacto_info.edit') }}" class="btn btn-sm btn-outline-info">
                <i class="bi bi-pencil"></i> Editar Contacto
            </a>
        </div>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-primary">
            <div class="card-body">
                <h6 class="text-muted">Total solicitudes</h6>
                <h3>{{ $totalSolicitudes }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-warning">
            <div class="card-body">
                <h6 class="text-muted">Pendientes</h6>
                <h3>{{ $solicitudesPendientes }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-success">
            <div class="card-body">
                <h6 class="text-muted">Servicios realizados</h6>
                <h3>{{ $serviciosCompletados }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-info">
            <div class="card-body">
                <h6 class="text-muted">Ingresos</h6>
                <h3>${{ number_format($ingresos, 0) }}</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Solicitudes recientes</span>
                <a href="{{ route('solicitudes.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Cliente</th>
                            <th>Servicio</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudesRecientes as $s)
                        <tr>
                            <td><a href="{{ route('admin.solicitudes.show', $s) }}">{{ $s->folio }}</a></td>
                            <td>{{ $s->user->name }}</td>
                            <td>{{ $s->servicio->nombre }}</td>
                            <td><span class="badge bg-secondary">{{ $s->estado }}</span></td>
                            <td>{{ $s->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
