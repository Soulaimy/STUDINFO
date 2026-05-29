@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Espace Responsable Pédagogique</h1>
        <span class="badge bg-primary">Connecté : {{ Auth::user()->name }}</span>
    </div>

    <div class="alert alert-info">
        Bienvenue dans votre espace. Vous pouvez ici :
        <ul class="mb-0 mt-2">
            <li>Consulter les inscriptions en attente de validation pédagogique</li>
            <li>Valider les inscriptions après validation administrative</li>
            <li>Suivre l’état des formations et des étudiants inscrits</li>
        </ul>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Accès rapide
        </div>
        <div class="card-body">
            <a href="{{ route('pedagogique.inscriptions') }}" class="btn btn-outline-primary me-2">
                 Gérer les inscriptions
            </a>
            <a href="{{ route('pedagogique.formations.index') }}" class="btn btn-outline-secondary">
                 Consulter les formations
            </a>
        </div>
    </div>
</div>
@endsection