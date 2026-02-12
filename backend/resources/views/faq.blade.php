@extends('layouts.app')

@section('title', 'Preguntas frecuentes - HANDY SOLUTIONS')

@section('content')
<h1 class="mb-4">Preguntas frecuentes</h1>
<div class="accordion" id="faqAccordion">
    @foreach($faqs as $index => $faq)
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->id }}">
                {{ $faq->pregunta }}
            </button>
        </h2>
        <div id="faq-{{ $faq->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                {!! nl2br(e($faq->respuesta)) !!}
            </div>
        </div>
    </div>
    @endforeach
</div>
@if($faqs->isEmpty())
    <p class="text-muted">No hay preguntas frecuentes publicadas aún.</p>
@endif
@endsection
