@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-4"><i class="fas fa-hourglass-half me-2"></i>Votre demande est en attente</h2>

    <p class="lead">Bonjour {{ Auth::user()->prenom }} {{ Auth::user()->nom }},</p>

    @else
        <p>Votre demande d'accès est en cours de traitement.</p>
        <p>Vous recevrez un email dès qu’un administrateur aura validé ou refusé votre demande.</p>
    @endif

    <div class="mt-5 d-flex justify-content-center gap-3">
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="fas fa-home me-1"></i> Retour à l’accueil
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt me-1"></i> Se déconnecter
            </button>
        </form>
    </div>
</div>
@endsection