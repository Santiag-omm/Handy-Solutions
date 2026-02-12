@extends('layouts.admin')

@section('title', 'Zonas de cobertura')

@section('content')
<h1 class="mb-4">Zonas de cobertura</h1>
<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card">
            <div class="card-header">Nueva zona</div>
            <div class="card-body">
                <form action="{{ route('admin.zonas.store') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre *" required>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="codigo" class="form-control" placeholder="Código">
                    </div>
                    <div class="mb-2">
                        <textarea name="descripcion" class="form-control" rows="2" placeholder="Descripción"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Técnicos</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($zonas as $z)
                <tr>
                    <td>{{ $z->nombre }}</td>
                    <td>{{ $z->codigo ?? '-' }}</td>
                    <td>{{ $z->tecnicos_count }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editZona{{ $z->id }}">Editar</button>
                        <form action="{{ route('admin.zonas.destroy', $z) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Desactivar zona?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Desactivar</button>
                        </form>
                    </td>
                </tr>
                <div class="modal fade" id="editZona{{ $z->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.zonas.update', $z) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar zona</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" value="{{ $z->nombre }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Código</label>
                                        <input type="text" name="codigo" class="form-control" value="{{ $z->codigo }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Descripción</label>
                                        <textarea name="descripcion" class="form-control" rows="2">{{ $z->descripcion }}</textarea>
                                    </div>
                                    <div class="form-check">
                                        <input type="hidden" name="activo" value="0">
                                        <input type="checkbox" name="activo" class="form-check-input" value="1" {{ $z->activo ? 'checked' : '' }}>
                                        <label class="form-check-label">Activo</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        {{ $zonas->links() }}
    </div>
</div>
@endsection
