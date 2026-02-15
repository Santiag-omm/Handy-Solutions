@extends('layouts.admin')

@section('title', 'Editar servicio')

@section('content')
<h1 class="mb-4">Editar servicio</h1>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.servicios.update', $servicio) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nombre *</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $servicio->nombre) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $servicio->descripcion) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio base *</label>
                    <input type="number" name="precio_base" class="form-control" step="0.01" value="{{ old('precio_base', $servicio->precio_base) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio mínimo *</label>
                    <input type="number" name="precio_min" class="form-control" step="0.01" value="{{ old('precio_min', $servicio->precio_min) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
                <small class="text-muted">O usa una URL externa (recomendado para evitar que se pierda en deploys)</small>
                @if($servicio->imagen || (isset($servicio->imagen_url) && $servicio->imagen_url))
                    <div class="mt-2">
                        <img src="{{ (isset($servicio->imagen_url) && $servicio->imagen_url) ? $servicio->imagen_url : asset('storage/' . $servicio->imagen) }}" alt="{{ $servicio->nombre }}" style="max-width:280px;width:100%;height:auto;object-fit:cover;border-radius:12px;">
                        <br><small class="text-muted">Imagen actual</small>
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label class="form-label">URL de Imagen (Opcional)</label>
                <input type="url" name="imagen_url" class="form-control" placeholder="https://images.unsplash.com/photo-..." value="{{ old('imagen_url', isset($servicio->imagen_url) ? $servicio->imagen_url : '') }}">
                <small class="text-muted">URL de imagen externa (Unsplash, Pexels, etc.) - No se pierde en deploys</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Orden</label>
                <input type="number" name="orden" class="form-control" value="{{ old('orden', $servicio->orden) }}">
            </div>
            <div class="mb-3 form-check">
                <input type="hidden" name="activo" value="0">
                <input type="checkbox" name="activo" class="form-check-input" id="activo" value="1" {{ old('activo', $servicio->activo) ? 'checked' : '' }}>
                <label class="form-check-label" for="activo">Activo</label>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.servicios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
