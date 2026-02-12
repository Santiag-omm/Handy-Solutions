@extends('layouts.admin')

@section('title', 'Mi cuenta')

@section('content')
<h1 class="mb-4">Mi cuenta</h1>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.account.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Contraseña actual (obligatoria para guardar cambios)</label>
                        <input type="password" name="current_password" class="form-control" required>
                        @error('current_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nueva contraseña (opcional)</label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
