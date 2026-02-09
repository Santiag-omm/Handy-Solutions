@extends('layouts.admin')

@section('title', 'Servicios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Servicios</h1>
    <a href="{{ route('admin.servicios.create') }}" class="btn btn-primary">Nuevo servicio</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Precio base</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($servicios as $s)
        <tr>
            <td>{{ $s->nombre }}</td>
            <td>${{ number_format($s->precio_base, 2) }}</td>
            <td>
                @if($s->activo)
                    <span class="badge bg-success">Activo</span>
                @else
                    <span class="badge bg-secondary">Inactivo</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.servicios.edit', $s) }}" class="btn btn-sm btn-outline-primary">Editar</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $servicios->links() }}
@endsection
