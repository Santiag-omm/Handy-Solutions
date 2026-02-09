@extends('layouts.admin')

@section('title', 'Clientes')

@section('content')
<h1 class="mb-4">Clientes</h1>
<form class="mb-3" method="GET">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Buscar por nombre o email" value="{{ request('q') }}">
        <button class="btn btn-primary" type="submit">Buscar</button>
    </div>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Solicitudes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $c)
        <tr>
            <td>{{ $c->name }}</td>
            <td>{{ $c->email }}</td>
            <td>{{ $c->phone ?? '-' }}</td>
            <td>{{ $c->solicitudes_count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $clientes->links() }}
@endsection
