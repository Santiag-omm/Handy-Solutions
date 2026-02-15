@extends('layouts.admin')

@section('title', 'Nuevo servicio')

@section('content')
<h1 class="mb-4">Nuevo servicio</h1>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.servicios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nombre *</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio base *</label>
                    <input type="number" name="precio_base" class="form-control" step="0.01" value="{{ old('precio_base', 0) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio mínimo *</label>
                    <input type="number" name="precio_min" class="form-control" step="0.01" value="{{ old('precio_min', 0) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">URL de Imagen (Opcional)</label>
                <input type="url" name="imagen_url" class="form-control" placeholder="https://images.unsplash.com/photo-..." value="{{ old('imagen_url') }}">
                <small class="text-muted">URL de imagen externa - No se pierde en deploys</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Orden</label>
                <input type="number" name="orden" class="form-control" value="{{ old('orden', 0) }}">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="activo" class="form-check-input" id="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="activo">Activo</label>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.servicios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
