@extends('layouts.admin')

@section('title', 'Técnicos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Técnicos</h1>
    <a href="{{ route('admin.tecnicos.create') }}" class="btn btn-primary">Nuevo técnico</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Servicios</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($tecnicos as $t)
        <tr>
            <td>{{ $t->user->name }}</td>
            <td>{{ $t->user->email }}</td>
            <td>{{ $t->ordenes_trabajo_count }}</td>
            <td>
                @if($t->activo)
                    <span class="badge bg-success">Activo</span>
                @else
                    <span class="badge bg-secondary">Inactivo</span>
                @endif
            </td>
            <td><a href="{{ route('admin.tecnicos.edit', $t) }}" class="btn btn-sm btn-outline-primary">Editar</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $tecnicos->links() }}
@endsection
