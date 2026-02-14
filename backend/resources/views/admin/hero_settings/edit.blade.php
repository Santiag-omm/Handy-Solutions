@extends('layouts.admin')

@section('title', 'Editar Hero')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Hero Principal</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver al Dashboard
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Configuración del Hero</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.hero_settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="activo" id="activo" {{ $heroSettings->activo ? 'checked' : '' }}>
                            <label class="form-check-label" for="activo">
                                Hero activo
                            </label>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Título Principal</label>
                                <input type="text" name="titulo" class="form-control" value="{{ $heroSettings->titulo }}" placeholder="Servicios Profesionales de Mantenimiento">
                                <small class="text-muted">Título principal que se muestra en el hero</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Subtítulo</label>
                                <input type="text" name="subtitulo" class="form-control" value="{{ $heroSettings->subtitulo }}" placeholder="Soluciones rápidas y confiables para tu hogar y negocio">
                                <small class="text-muted">Subtítulo debajo del título principal</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3">{{ $heroSettings->descripcion }}</textarea>
                        <small class="text-muted">Descripción detallada del servicio</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">URL de Imagen de Fondo</label>
                        <input type="url" name="imagen_fondo" class="form-control" value="{{ $heroSettings->imagen_fondo }}" placeholder="https://images.unsplash.com/photo-...">
                        <small class="text-muted">URL de la imagen de fondo (recomendado: 1200x600px)</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Texto del Botón</label>
                                <input type="text" name="texto_boton" class="form-control" value="{{ $heroSettings->texto_boton }}" placeholder="Solicitar Servicio">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Enlace del Botón</label>
                                <input type="text" name="enlace_boton" class="form-control" value="{{ $heroSettings->enlace_boton }}" placeholder="#/solicitar-servicio">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Actualizar Hero
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
                <div class="hero-preview rounded-3 p-4 text-center position-relative overflow-hidden" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ $heroSettings->imagen_fondo }}'); background-size: cover; background-position: center; color: white; min-height: 200px; display: flex; flex-direction: column; justify-content: center;">
                    <h5 class="fw-bold text-white">{{ $heroSettings->titulo ?: 'Título del Hero' }}</h5>
                    <p class="text-white">{{ $heroSettings->subtitulo ?: 'Subtítulo del Hero' }}</p>
                    <p class="text-white-50 small">{{ $heroSettings->descripcion ?: 'Descripción del Hero' }}</p>
                    @if($heroSettings->texto_boton)
                    <button class="btn btn-warning btn-sm mt-2">
                        <i class="bi bi-tools"></i> {{ $heroSettings->texto_boton }}
                    </button>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Imágenes Sugeridas</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <small class="text-muted">Imágenes de Unsplash relacionadas con handyman:</small>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setHeroImage('https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=1200&h=600&fit=crop&auto=format')">
                        Herramientas profesionales
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setHeroImage('https://images.unsplash.com/photo-1621905251189-08b3e6a9b1d3?w=1200&h=600&fit=crop&auto=format')">
                        Técnico trabajando
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setHeroImage('https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=1200&h=600&fit=crop&auto=format')">
                        Plomería profesional
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setHeroImage('https://images.unsplash.com/photo-1581094358584-9c5e5f9a8f9b?w=1200&h=600&fit=crop&auto=format')">
                        Electricista trabajando
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setHeroImage('https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=1200&h=600&fit=crop&auto=format')">
                        Reparaciones en casa
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">Instrucciones</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <ul class="mb-0">
                        <li>Usa imágenes de alta calidad (1200x600px recomendado)</li>
                        <li>Las imágenes deben ser de servicios de mantenimiento</li>
                        <li>Puedes usar las URLs sugeridas o subir tus propias imágenes</li>
                        <li>El hero se mostrará solo si está marcado como activo</li>
                    </ul>
                </small>
            </div>
        </div>
    </div>
</div>

<script>
function setHeroImage(url) {
    document.querySelector('input[name="imagen_fondo"]').value = url;
    updatePreview();
}

function updatePreview() {
    const imageUrl = document.querySelector('input[name="imagen_fondo"]').value;
    const preview = document.querySelector('.hero-preview');
    preview.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('${imageUrl}')`;
}

// Actualizar preview cuando cambia la imagen
document.querySelector('input[name="imagen_fondo"]').addEventListener('input', updatePreview);
</script>
@endsection
