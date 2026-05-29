@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-primary">✏️ Modifier la formation</h2>

    <form action="{{ route('admin.formations.update', $formation->id) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        {{-- Titre --}}
        <div class="mb-3">
            <label for="titre" class="form-label">Titre :</label>
            <input 
                type="text" 
                name="titre" 
                id="titre" 
                class="form-control @error('titre') is-invalid @enderror" 
                value="{{ old('titre', $formation->titre) }}" 
                required
            >
            @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description :</label>
            <textarea 
                name="description" 
                id="description" 
                class="form-control @error('description') is-invalid @enderror" 
                rows="4" 
                required
            >{{ old('description', $formation->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Durée --}}
        <div class="mb-3">
            <label for="duree" class="form-label">Durée (en heures) :</label>
            <input 
                type="number" 
                name="duree" 
                id="duree" 
                class="form-control @error('duree') is-invalid @enderror" 
                value="{{ old('duree', $formation->duree) }}" 
                min="1" 
                required
            >
            @error('duree')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Bouton --}}
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

{{-- Optionnel : validation bootstrap JS --}}
<script>
    // Exemple simple pour activer la validation Bootstrap
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection