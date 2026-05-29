@extends('layouts.app')

@section('content')
<style>
    .espace-etudiant-wrapper {
        background-color: #f0f4f8;
        min-height: 80vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .espace-card {
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        max-width: 1300px;
        width: 100%;
        text-align: center;
    }

    .espace-card h1 {
        margin-bottom: 10px;
        color: #0d6efd;
    }

    .espace-card p {
        font-size: 16px;
        color: #555;
        margin-bottom: 25px;
    }

    .espace-card .btn {
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .btn-formations {
        background-color: #0d6efd;
        color: white;
        border: none;
        margin-right: 10px;
    }

    .btn-formations:hover {
        background-color: #0b5ed7;
    }

    .btn-inscriptions {
        background-color: #6c757d;
        color: white;
        border: none;
    }

    .btn-inscriptions:hover {
        background-color: #5a6268;
    }

    .info-list {
        text-align: left;
        margin-top: 20px;
    }

    .info-list li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .info-list strong {
        color: #333;
    }
</style>

<div class="espace-etudiant-wrapper">
    <div class="espace-card">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php
            $inscription = Auth::user()->inscriptions()->latest()->first();
        @endphp

        @if($inscription && $inscription->paiement_effectue && $inscription->valide_admin && $inscription->valide_pedagogique)
            {{-- Inscription finalisée -> afficher dashboard rentrée --}}
            <h1> Bienvenue {{ Auth::user()->name }}</h1>
            <p>Votre inscription à <strong>{{ $inscription->formation->titre }}</strong> est finalisée !</p>
            <div style="background-color: #fff3cd; border: 1px solid #ffeeba; padding: 15px 20px; border-radius: 8px; color: #a98006; font-size: 16px; font-weight: 500; text-align: center;">
                Bienvenue dans notre établissement ! Vous faites désormais partie des étudiants de <strong>Studinfo</strong>. Nous vous souhaitons une belle réussite 
            </div>

            <ul class="list-group info-list mb-4">
                <li><strong> Journée d'integration:</strong> 13 novembre 2025</li>
                <li><strong> Salle :</strong> Bâtiment A </li>
                <li><strong> Date de rentrée :</strong> 16 novembre 2025</li>
                <li><strong> Professeur référent :</strong> M.Anis Bennamar</li>
                <li><strong> Contact référent :</strong> anis@ecole.com</li>
            </ul>

             <div>
                <h5> Emploi du temps</h5>
                <p>Regardez votre emploi du temps de la semaine </p>
                <a href="https://www.canva.com/design/DAGyebcAqqM/cRVDiY-ECAtoTQ4Gl4B51w/view?utm_content=DAGyebcAqqM&utm_campaign=designshare&utm_medium=link2&utm_source=uniquelinks&utlId=h870c33e637"
                   class="btn btn-primary"
                   target="_blank"
                   rel="noopener noreferrer">
                     Voir le planning
                </a>
            </div>

        @else
            {{-- Inscription non finalisée -> message normal --}}
            <h1>Bienvenue {{ Auth::user()->name }}</h1>
            <p>
                Vous pouvez désormais suivre l’état d’avancement de votre inscription<br>
                en cliquant sur <strong>« Mes Inscriptions »</strong> ci-dessous.
            </p>

            <div class="d-flex justify-content-center">
                <a href="{{ route('etudiant.formations') }}" class="btn btn-inscriptions">Voir les Formations</a>
                <a href="{{ route('etudiant.inscriptions') }}" class="btn btn-formations me-2">Mes Inscriptions</a>
            </div>
        @endif

    </div>
</div>
@endsection