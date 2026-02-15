@extends('layouts.admin')

@section('title', 'Debug Test')

@section('content')
<div class="card">
    <div class="card-body">
        <h1 class="text-success">✅ Debug Test - Vista Funciona</h1>
        <p>Si puedes ver esta página, el problema está en el controlador de servicios.</p>
        
        <div class="mt-4">
            <h3>Información de Depuración:</h3>
            <ul>
                <li>Usuario: {{ Auth::user()?->name ?? 'No autenticado' }}</li>
                <li>Ruta actual: {{ Route::currentRouteName() }}</li>
                <li>URL: {{ request()->fullUrl() }}</li>
                <li>CSRF Token: {{ csrf_token() }}</li>
            </ul>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('admin.servicios.index') }}" class="btn btn-primary">Ir a Servicios</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Ir al Dashboard</a>
        </div>
    </div>
</div>
@endsection
