@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Inscriptions à la formation : {{ $formation->titre }}</h2>

    @if($inscriptions->isEmpty())
        <div class="alert alert-info">
            Aucun étudiant inscrit pour le moment.
        </div>
    @else
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Date d'inscription</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscriptions as $inscription)
                    <tr>
                        <td>{{ $inscription->etudiant->name ?? 'Nom inconnu' }}</td>
                        <td>{{ $inscription->etudiant->email ?? '-' }}</td>
                        <td>{{ $inscription->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if ($inscription->valide === true)
                                <span class="badge bg-success">Validée</span>
                            @elseif ($inscription->valide === false)
                                <span class="badge bg-danger">Refusée</span>
                            @else
                                <span class="badge bg-secondary">En attente</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('pedagogique.formations.index') }}" class="btn btn-secondary mt-3">← Retour</a>
</div>
@endsection