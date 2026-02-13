@extends('layouts.admin')

@section('title', 'Contactos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mensajes de Contacto</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.contacto_info.edit') }}" class="btn btn-sm btn-outline-warning">
                <i class="bi bi-pencil"></i> Editar Información
            </a>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="marcarSeleccionadosLeidos()">
                <i class="bi bi-check2"></i> Marcar como leídos
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarSeleccionados()">
                <i class="bi bi-trash"></i> Eliminar seleccionados
            </button>
        </div>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $stats['total'] }}</h5>
                <p class="card-text">Total</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-warning">{{ $stats['pendientes'] }}</h5>
                <p class="card-text">Pendientes</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-info">{{ $stats['leidos'] }}</h5>
                <p class="card-text">Leídos</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-success">{{ $stats['respondidos'] }}</h5>
                <p class="card-text">Respondidos</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-secondary">{{ $stats['hoy'] }}</h5>
                <p class="card-text">Hoy</p>
            </div>
        </div>
    </div>
</div>

<!-- Lista de mensajes -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Mensajes Recibidos</h5>
    </div>
    <div class="card-body">
        @if($contactos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll" onchange="toggleSelectAll()"></th>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contactos as $contacto)
                            <tr class="{{ $contacto->estado === 'pendiente' ? 'table-warning' : '' }}">
                                <td><input type="checkbox" class="contact-checkbox" value="{{ $contacto->id }}"></td>
                                <td>{{ $contacto->fecha_envio->format('d/m/Y H:i') }}</td>
                                <td>{{ $contacto->nombre }}</td>
                                <td>{{ $contacto->email }}</td>
                                <td>{{ $contacto->telefono ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($contacto->asunto) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $contacto->estado === 'pendiente' ? 'warning' : ($contacto->estado === 'respondido' ? 'success' : 'info') }}">
                                        {{ ucfirst($contacto->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.contactos.show', $contacto) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.contactos.destroy', $contacto) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar este mensaje?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $contactos->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-envelope display-1 text-muted"></i>
                <h4 class="mt-3 text-muted">No hay mensajes</h4>
                <p class="text-muted">Los mensajes de contacto aparecerán aquí cuando los usuarios envíen el formulario.</p>
            </div>
        @endif
    </div>
</div>

<script>
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function getSelectedIds() {
    const checkboxes = document.querySelectorAll('.contact-checkbox:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

function marcarSeleccionadosLeidos() {
    const ids = getSelectedIds();
    
    if (ids.length === 0) {
        alert('Por favor, selecciona al menos un mensaje.');
        return;
    }
    
    fetch('{{ route("admin.contactos.marcarLeidos") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids: ids })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function eliminarSeleccionados() {
    const ids = getSelectedIds();
    
    if (ids.length === 0) {
        alert('Por favor, selecciona al menos un mensaje.');
        return;
    }
    
    if (!confirm(`¿Estás seguro de eliminar ${ids.length} mensaje(s)?`)) {
        return;
    }
    
    fetch('{{ route("admin.contactos.eliminarMultiples") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids: ids })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endsection
