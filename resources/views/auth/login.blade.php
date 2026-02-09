@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-4">
                <h2 class="card-title mb-4">Iniciar sesión</h2>
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $e)
                            <div>{{ $e }}</div>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
                <p class="mt-3 mb-0 text-center small">
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
