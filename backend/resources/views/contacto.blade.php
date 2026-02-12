@extends('layouts.app')

@section('title', 'Contacto - HANDY SOLUTIONS')

@section('content')
<h1 class="mb-4">Contacto</h1>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Datos de contacto</h5>
                <p><i class="bi bi-geo-alt text-primary me-2"></i> Dirección de la empresa</p>
                <p><i class="bi bi-telephone text-primary me-2"></i> Teléfono</p>
                <p><i class="bi bi-envelope text-primary me-2"></i> contacto@handyplus.com</p>
                <p class="text-muted small">Horario de atención: Lunes a Viernes 8:00 - 18:00</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">¿Necesitas un servicio?</h5>
                <p>Utiliza el formulario de <a href="{{ route('solicitudes.create') }}">solicitud de servicio</a> para describir tu necesidad y recibir una cotización.</p>
            </div>
        </div>
    </div>
</div>
@endsection
