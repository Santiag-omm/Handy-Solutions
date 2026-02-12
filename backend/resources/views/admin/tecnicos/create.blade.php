@extends('layouts.admin')

@section('title', 'Nuevo técnico')

@section('content')
<h1 class="mb-4">Nuevo técnico</h1>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.tecnicos.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nombre *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña *</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmar contraseña *</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Especialidades</label>
                <input type="text" name="especialidades" class="form-control" value="{{ old('especialidades') }}" placeholder="Ej: plomería, electricidad">
            </div>
            <div class="mb-3">
                <label class="form-label">Zonas de cobertura</label>
                <select name="zonas[]" class="form-select" multiple>
                    @foreach($zonas as $z)
                        <option value="{{ $z->id }}" {{ in_array($z->id, old('zonas', [])) ? 'selected' : '' }}>{{ $z->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.tecnicos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
