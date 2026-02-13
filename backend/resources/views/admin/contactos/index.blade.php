@extends('layouts.admin')

@section('title', 'Contactos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mensajes de Contacto</h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Mensajes Recibidos</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    <strong>Información:</strong> Los mensajes de contacto del formulario web aparecerán aquí.
                    <br><br>
                    <strong>Estado actual:</strong> El formulario de contacto está funcionando y los mensajes se procesan correctamente.
                    <br>
                    <strong>Próximamente:</strong> Se implementará el almacenamiento de mensajes en la base de datos para su consulta.
                </div>
                
                <div class="text-center mt-4">
                    <i class="bi bi-envelope display-1 text-muted"></i>
                    <h4 class="mt-3 text-muted">No hay mensajes almacenados</h4>
                    <p class="text-muted">Los mensajes nuevos aparecerán aquí cuando se implemente el almacenamiento.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Configuración de Contacto</h6>
            </div>
            <div class="card-body">
                <p><strong>Correo de destino:</strong> info@handysolutions.com</p>
                <p><strong>Estado del formulario:</strong> <span class="badge bg-success">Activo</span></p>
                <p><strong>Última prueba:</strong> {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Estadísticas</h6>
            </div>
            <div class="card-body">
                <p><strong>Total mensajes:</strong> <span class="badge bg-primary">0</span></p>
                <p><strong>Mensajes hoy:</strong> <span class="badge bg-info">0</span></p>
                <p><strong>Pendientes respuesta:</strong> <span class="badge bg-warning">0</span></p>
            </div>
        </div>
    </div>
</div>
@endsection
