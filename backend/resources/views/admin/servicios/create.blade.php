@extends('layouts.admin')

@section('title', 'Nuevo servicio')

@section('content')
<h1 class="mb-4">Nuevo servicio</h1>
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.servicios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nombre *</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio base *</label>
                    <input type="number" name="precio_base" class="form-control" step="0.01" value="{{ old('precio_base', 0) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio mínimo *</label>
                    <input type="number" name="precio_min" class="form-control" step="0.01" value="{{ old('precio_min', 0) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input type="file" name="imagen" class="form-control" accept="image/*">
                <small class="text-muted">O usa una URL externa (recomendado para evitar que se pierda en deploys)</small>
            </div>
            <div class="mb-3">
                <label class="form-label">URL de Imagen (Opcional)</label>
                <div class="input-group">
                    <input type="url" name="imagen_url" id="imagen_url" class="form-control" placeholder="https://images.unsplash.com/photo-..." value="{{ old('imagen_url') }}">
                    <button class="btn btn-outline-secondary" type="button" id="validateUrlBtn">
                        <i class="bi bi-check-circle"></i> Validar
                    </button>
                </div>
                <div id="validationResult" class="mt-2"></div>
                <small class="text-muted">URL de imagen externa (Unsplash, Pexels, etc.) - No se pierde en deploys</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Orden</label>
                <input type="number" name="orden" class="form-control" value="{{ old('orden', 0) }}">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="activo" class="form-check-input" id="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="activo">Activo</label>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('admin.servicios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const validateBtn = document.getElementById('validateUrlBtn');
    const urlInput = document.getElementById('imagen_url');
    const resultDiv = document.getElementById('validationResult');
    
    validateBtn.addEventListener('click', async function() {
        const url = urlInput.value.trim();
        
        if (!url) {
            showResult('Por favor ingresa una URL', 'warning');
            return;
        }
        
        // Mostrar estado de carga
        validateBtn.disabled = true;
        validateBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Validando...';
        showResult('Validando URL...', 'info');
        
        try {
            const response = await fetch('{{ route("validate_image_url") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ url: url })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showResult(`
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i> ${data.message}
                        <br><small>
                            Tipo: ${data.details.content_type} | 
                            Tamaño: ${data.details.size} | 
                            Status: ${data.details.status}
                        </small>
                    </div>
                `, 'success');
                
                // Mostrar vista previa
                showImagePreview(url);
            } else {
                showResult(`
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle-fill"></i> ${data.error}
                    </div>
                `, 'error');
            }
        } catch (error) {
            showResult(`
                <div class="alert alert-danger">
                    <i class="bi bi-x-circle-fill"></i> Error de conexión: ${error.message}
                </div>
            `, 'error');
        } finally {
            validateBtn.disabled = false;
            validateBtn.innerHTML = '<i class="bi bi-check-circle"></i> Validar';
        }
    });
    
    function showResult(html, type) {
        resultDiv.innerHTML = html;
    }
    
    function showImagePreview(url) {
        // Si ya existe una vista previa, actualizarla
        let previewDiv = document.getElementById('imagePreview');
        if (!previewDiv) {
            previewDiv = document.createElement('div');
            previewDiv.id = 'imagePreview';
            previewDiv.className = 'mt-3';
            resultDiv.appendChild(previewDiv);
        }
        
        previewDiv.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Vista Previa</h6>
                    <img src="${url}" alt="Vista previa" style="max-width:300px;width:100%;height:auto;object-fit:cover;border-radius:8px;" onerror="this.parentElement.innerHTML='<div class=\\'alert alert-warning\\'><i class=\\'bi bi-exclamation-triangle\\'></i> La imagen no se pudo cargar</div>'">
                </div>
            </div>
        `;
    }
    
    // Validación automática al salir del campo (opcional)
    let timeout;
    urlInput.addEventListener('blur', function() {
        if (this.value.trim()) {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                validateBtn.click();
            }, 500);
        }
    });
});
</script>
@endpush
