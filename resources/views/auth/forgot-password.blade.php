@extends('layouts.app')

@section('title', 'Recuperar contraseña')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-4">
                <h2 class="card-title mb-4">Recuperar contraseña</h2>
                <p class="text-muted">Indica tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar enlace</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
