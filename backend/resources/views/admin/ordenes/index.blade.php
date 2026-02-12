@extends('layouts.admin')

@section('title', 'Órdenes de trabajo')

@section('content')
<h1 class="mb-4">Órdenes de trabajo</h1>
<form class="mb-3 row g-2" method="GET">
    <div class="col-auto">
        <select name="estado" class="form-select form-select-sm">
            <option value="">Todos</option>
            @foreach(['asignada','en_camino','en_proceso','completada','cancelada'] as $e)
                <option value="{{ $e }}" {{ request('estado') === $e ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$e)) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-sm btn-primary" type="submit">Filtrar</button>
    </div>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Código</th>
            <th>Solicitud</th>
            <th>Cliente</th>
            <th>Técnico</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($ordenes as $o)
        <tr>
            <td><a href="{{ route('admin.ordenes.show', $o) }}">{{ $o->codigo }}</a></td>
            <td>{{ $o->solicitud->folio }}</td>
            <td>{{ $o->solicitud->user->name }}</td>
            <td>{{ $o->tecnico->user->name }}</td>
            <td><span class="badge bg-secondary">{{ $o->estado }}</span></td>
            <td>{{ $o->fecha_asignada?->format('d/m/Y') }}</td>
            <td><a href="{{ route('admin.ordenes.show', $o) }}" class="btn btn-sm btn-outline-primary">Ver</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $ordenes->links() }}
@endsection
