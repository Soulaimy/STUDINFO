@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <h2 class="mb-4 text-primary fw-bold">
                 Profil de l’étudiant : <span class="text-dark">{{ $etudiant->name }}</span>
            </h2>
            <p class="mb-4">
                <strong class="text-secondary"> Email :</strong> {{ $etudiant->email }}
            </p>

            @foreach($etudiant->inscriptions as $inscription)
                <div class="card mb-5 border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h4 class="text-info mb-3"> Formation : {{ $inscription->formation->titre ?? 'Non défini' }}</h4>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-2">
                                <strong class="text-secondary"> Département :</strong> {{ $inscription->user->departement }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong class="text-secondary"> Ville :</strong> {{ $inscription->user->ville }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong class="text-secondary"> Date de naissance :</strong> 
                                {{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong class="text-secondary"> Diplôme obtenu :</strong> {{ $inscription->nom_diplome }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong class="text-secondary"> Moyenne :</strong> {{ $inscription->moyenne }}/20
                            </div>
                        </div>
<div class="mt-3">
    <p class="mb-2">
        <strong class="text-secondary">Carte d'identité :</strong>
        @if($inscription->carte_identite)
            <a href="{{ asset('storage/' . $inscription->carte_identite)}}" target="_blank" class="btn btn-outline-primary btn-sm ms-2">
                Voir la carte d'identité
            </a>
        @else
            <span class="text-danger">Document non disponible</span>
        @endif
    </p>

    <p class="mb-2">
        <strong class="text-secondary">Diplôme :</strong>
        @if($inscription->diplome)
            <a href="{{ asset('storage/'. $inscription->diplome) }}" target="_blank" class="btn btn-outline-primary btn-sm ms-2">
                Voir le diplôme
            </a>
        @else
            <span class="text-danger">Document non disponible</span>
        @endif
    </p>
</div>

 <div class="mt-4">
     <p>
        <strong class="text-secondary"> Paiement des frais d'inscription :</strong>
         @if($inscription->paiement_effectue)
                <span class="badge bg-success ms-2 px-3 py-2">Payé</span>
                                @else
                                <span class="badge bg-danger ms-2 px-3 py-2">Pas encore payé</span>
                                 @endif
                             </p>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="text-end">
                <a href="{{ route('admin.inscriptions') }}" class="btn btn-secondary btn-lg px-4">
                    ⬅ Retour à la liste des étudiants
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

                       