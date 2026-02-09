@extends('layouts.admin')

@section('title', 'Editar técnico')

@section('content')
<h1 class="mb-4">Editar técnico</h1>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.tecnicos.update', $tecnico) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nombre *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $tecnico->user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $tecnico->user->email) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $tecnico->user->phone) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Nueva contraseña (dejar en blanco para no cambiar)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Especialidades</label>
                <input type="text" name="especialidades" class="form-control" value="{{ old('especialidades', $tecnico->especialidades) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Zonas de cobertura</label>
                <select name="zonas[]" class="form-select" multiple>
                    @foreach($zonas as $z)
                        <option value="{{ $z->id }}" {{ $tecnico->zonas->contains($z) ? 'selected' : '' }}>{{ $z->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 form-check">
                <input type="hidden" name="activo" value="0">
                <input type="checkbox" name="activo" class="form-check-input" id="activo" value="1" {{ old('activo', $tecnico->activo) ? 'checked' : '' }}>
                <label class="form-check-label" for="activo">Activo</label>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.tecnicos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
