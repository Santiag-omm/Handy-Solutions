@extends('layouts.admin')

@section('title', 'Editar Información de Contacto')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Información de Contacto</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.contactos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver a Contactos
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Información de Contacto</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contacto_info.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control" value="{{ $contactoInfo->direccion }}" placeholder="Calle Principal #123, Colonia Centro">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Horario</label>
                                <input type="text" name="horario" class="form-control" value="{{ $contactoInfo->horario }}" placeholder="Lunes a Viernes: 8:00 AM - 6:00 PM">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Teléfono Principal</label>
                                <input type="text" name="telefono1" class="form-control" value="{{ $contactoInfo->telefono1 }}" placeholder="(555) 123-4567">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Teléfono Secundario</label>
                                <input type="text" name="telefono2" class="form-control" value="{{ $contactoInfo->telefono2 }}" placeholder="(555) 891-0123">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email Principal</label>
                                <input type="email" name="email1" class="form-control" value="{{ $contactoInfo->email1 }}" placeholder="info@handysolutions.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email Secundario</label>
                                <input type="email" name="email2" class="form-control" value="{{ $contactoInfo->email2 }}" placeholder="soporte@handysolutions.com">
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6 class="mb-3">Redes Sociales</h6>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="url" name="facebook" class="form-control" value="{{ $contactoInfo->facebook }}" placeholder="https://facebook.com/tu-pagina">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Instagram</label>
                                <input type="url" name="instagram" class="form-control" value="{{ $contactoInfo->instagram }}" placeholder="https://instagram.com/tu-perfil">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Twitter</label>
                                <input type="url" name="twitter" class="form-control" value="{{ $contactoInfo->twitter }}" placeholder="https://twitter.com/tu-perfil">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control" value="{{ $contactoInfo->whatsapp }}" placeholder="https://wa.me/1234567890">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Actualizar Información
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Vista Previa</h6>
            </div>
            <div class="card-body">
                <h6 class="text-primary mb-3">Información de Contacto</h6>
                
                <div class="mb-2">
                    <strong>Dirección:</strong><br>
                    <small>{{ $contactoInfo->direccion ?: 'No configurada' }}</small>
                </div>
                
                <div class="mb-2">
                    <strong>Teléfonos:</strong><br>
                    <small>{{ $contactoInfo->telefono1 ?: 'No configurado' }}</small><br>
                    <small>{{ $contactoInfo->telefono2 ?: 'No configurado' }}</small>
                </div>
                
                <div class="mb-2">
                    <strong>Emails:</strong><br>
                    <small>{{ $contactoInfo->email1 ?: 'No configurado' }}</small><br>
                    <small>{{ $contactoInfo->email2 ?: 'No configurado' }}</small>
                </div>
                
                <div class="mb-2">
                    <strong>Horario:</strong><br>
                    <small>{{ $contactoInfo->horario ?: 'No configurado' }}</small>
                </div>
                
                <hr>
                
                <h6 class="text-primary mb-3">Redes Sociales</h6>
                
                @if($contactoInfo->facebook)
                <div class="mb-1">
                    <i class="bi bi-facebook text-primary"></i>
                    <small>Facebook configurado</small>
                </div>
                @endif
                
                @if($contactoInfo->instagram)
                <div class="mb-1">
                    <i class="bi bi-instagram text-danger"></i>
                    <small>Instagram configurado</small>
                </div>
                @endif
                
                @if($contactoInfo->twitter)
                <div class="mb-1">
                    <i class="bi bi-twitter text-info"></i>
                    <small>Twitter configurado</small>
                </div>
                @endif
                
                @if($contactoInfo->whatsapp)
                <div class="mb-1">
                    <i class="bi bi-whatsapp text-success"></i>
                    <small>WhatsApp configurado</small>
                </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Instrucciones</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <ul class="mb-0">
                        <li>Completa los campos que quieras mostrar</li>
                        <li>Los campos vacíos no se mostrarán en el frontend</li>
                        <li>Las URLs deben incluir https://</li>
                        <li>WhatsApp usa formato: https://wa.me/número</li>
                    </ul>
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
