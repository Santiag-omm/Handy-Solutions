@extends('layouts.app')

@section('title', 'Solicitar servicio - HANDY SOLUTIONS')

@section('content')
<h1 class="mb-4">Solicitar servicio</h1>
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('solicitudes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tipo de servicio *</label>
                        <select name="servicio_id" class="form-select @error('servicio_id') is-invalid @enderror" required>
                            <option value="">Selecciona...</option>
                            @foreach($servicios as $s)
                                <option value="{{ $s->id }}" {{ old('servicio_id', request('servicio')) == $s->id ? 'selected' : '' }}>{{ $s->nombre }}</option>
                            @endforeach
                        </select>
                        @error('servicio_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Zona de cobertura</label>
                        <select name="zona_id" class="form-select">
                            <option value="">Selecciona...</option>
                            @foreach($zonas as $z)
                                <option value="{{ $z->id }}" {{ old('zona_id') == $z->id ? 'selected' : '' }}>{{ $z->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección *</label>
                        <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}" required>
                        @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción del problema</label>
                        <textarea name="descripcion_problema" class="form-control" rows="3">{{ old('descripcion_problema') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha deseada</label>
                            <input type="date" name="fecha_deseada" class="form-control" value="{{ old('fecha_deseada') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nivel de urgencia *</label>
                            <select name="urgencia" class="form-select" required>
                                <option value="baja" {{ old('urgencia') === 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ old('urgencia', 'media') === 'media' ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ old('urgencia') === 'alta' ? 'selected' : '' }}>Alta</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fotos del problema (opcional)</label>
                        <input type="file" name="fotos[]" class="form-control" accept="image/*" multiple>
                        <small class="text-muted">Formatos: jpeg, png, jpg, gif. Máx. 5 MB por imagen.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar solicitud</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-light">
            <div class="card-body">
                <h5>Proceso</h5>
                <ol class="small">
                    <li>Envías tu solicitud</li>
                    <li>Recibes una cotización automática</li>
                    <li>Validamos y asignamos un técnico</li>
                    <li>Se realiza el servicio</li>
                    <li>Pago y reseña</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
