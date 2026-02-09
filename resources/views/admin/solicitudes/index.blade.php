@extends('layouts.admin')

@section('title', 'Solicitudes')

@section('content')
<h1 class="mb-4">Solicitudes</h1>
<form class="mb-3 row g-2" method="GET">
    <div class="col-auto">
        <select name="estado" class="form-select form-select-sm">
            <option value="">Todos los estados</option>
            @foreach(['pendiente','validada','rechazada','cotizada','asignada','en_proceso','completada','cancelada'] as $e)
                <option value="{{ $e }}" {{ request('estado') === $e ? 'selected' : '' }}>{{ ucfirst($e) }}</option>
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
            <th>Folio</th>
            <th>Cliente</th>
            <th>Servicio</th>
            <th>Cotización</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($solicitudes as $s)
        <tr>
            <td><a href="{{ route('admin.solicitudes.show', $s) }}">{{ $s->folio }}</a></td>
            <td>{{ $s->user->name }}</td>
            <td>{{ $s->servicio->nombre }}</td>
            <td>
                @if($s->cotizacionActual)
                    ${{ number_format($s->cotizacionActual->monto, 0) }}
                @else
                    -
                @endif
            </td>
            <td><span class="badge bg-secondary">{{ $s->estado }}</span></td>
            <td>{{ $s->created_at->format('d/m/Y') }}</td>
            <td><a href="{{ route('admin.solicitudes.show', $s) }}" class="btn btn-sm btn-outline-primary">Ver</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $solicitudes->links() }}
@endsection
