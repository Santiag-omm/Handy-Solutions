@extends('layouts.app')

@section('title', 'Galería de trabajos - HANDY SOLUTIONS')

@section('content')
<h1 class="mb-4">Trabajos realizados</h1>
<div class="row g-4">
    @forelse($trabajos as $item)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ asset('storage/' . $item->imagen) }}" class="card-img-top" alt="{{ $item->titulo }}" style="height:220px;object-fit:cover">
            <div class="card-body">
                @if($item->titulo)
                    <h5 class="card-title">{{ $item->titulo }}</h5>
                @endif
                @if($item->descripcion)
                    <p class="card-text small text-muted">{{ Str::limit($item->descripcion, 80) }}</p>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 text-muted">
        <i class="bi bi-images display-4"></i>
        <p class="mt-2">Próximamente más trabajos en la galería.</p>
    </div>
    @endforelse
</div>
@if($trabajos->hasPages())
    <div class="d-flex justify-content-center mt-4">{{ $trabajos->links() }}</div>
@endif
@endsection
