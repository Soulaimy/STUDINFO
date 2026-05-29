@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Créer une nouvelle formation</h2>

    <form action="{{ route('admin.formations.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="titre" class="form-label">Titre de la formation</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="duree" class="form-label">Durée (en heures)</label>
            <input type="number" name="duree" id="duree" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Créer la formation</button>
    </form>
</div>
@endsection
