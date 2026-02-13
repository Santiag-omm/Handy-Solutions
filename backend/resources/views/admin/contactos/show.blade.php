@extends('layouts.admin')

@section('title', 'Detalle de Contacto')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detalle del Mensaje</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.contactos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Información del Mensaje</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Nombre:</strong></div>
                    <div class="col-md-8">{{ $contacto->nombre }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Email:</strong></div>
                    <div class="col-md-8">
                        <a href="mailto:{{ $contacto->email }}">{{ $contacto->email }}</a>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Teléfono:</strong></div>
                    <div class="col-md-8">
                        {{ $contacto->telefono ? '<a href="tel:' . $contacto->telefono . '">' . $contacto->telefono . '</a>' : '-' }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Asunto:</strong></div>
                    <div class="col-md-8">
                        <span class="badge bg-secondary">{{ ucfirst($contacto->asunto) }}</span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Fecha de envío:</strong></div>
                    <div class="col-md-8">{{ $contacto->fecha_envio->format('d/m/Y H:i:s') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Estado:</strong></div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $contacto->estado === 'pendiente' ? 'warning' : ($contacto->estado === 'respondido' ? 'success' : 'info') }}">
                            {{ ucfirst($contacto->estado) }}
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Mensaje:</strong></div>
                    <div class="col-md-8">
                        <div class="border rounded p-3 bg-light">
                            {{ nl2br(e($contacto->mensaje)) }}
                        </div>
                    </div>
                </div>
                
                @if($contacto->fecha_respuesta)
                <div class="row mb-3">
                    <div class="col-md-4"><strong>Fecha de respuesta:</strong></div>
                    <div class="col-md-8">{{ $contacto->fecha_respuesta->format('d/m/Y H:i:s') }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Acciones</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contactos.updateEstado', $contacto) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" onchange="this.form.submit()">
                            <option value="pendiente" {{ $contacto->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="leído" {{ $contacto->estado === 'leído' ? 'selected' : '' }}>Leído</option>
                            <option value="respondido" {{ $contacto->estado === 'respondido' ? 'selected' : '' }}>Respondido</option>
                            <option value="cerrado" {{ $contacto->estado === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Notas administrativas</label>
                        <textarea name="notas_admin" class="form-control" rows="4">{{ $contacto->notas_admin }}</textarea>
                        <small class="text-muted">Notas internas sobre este contacto</small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Actualizar
                        </button>
                        
                        <a href="mailto:{{ $contacto->email }}" class="btn btn-success">
                            <i class="bi bi-envelope"></i> Responder por email
                        </a>
                        
                        <form action="{{ route('admin.contactos.destroy', $contacto) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este mensaje?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash"></i> Eliminar mensaje
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Información rápida</h6>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 mb-2">
                    <a href="mailto:{{ $contacto->email }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-envelope"></i> Email
                    </a>
                    @if($contacto->telefono)
                    <a href="tel:{{ $contacto->telefono }}" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-telephone"></i> Llamar
                    </a>
                    @endif
                </div>
                
                <hr>
                
                <small class="text-muted">
                    <strong>ID:</strong> #{{ $contacto->id }}<br>
                    <strong>IP:</strong> No disponible<br>
                    <strong>User Agent:</strong> No disponible
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
