@extends('layouts.app')

@section('content')
<div class="container">
    <h4>📋 Gestion des Inscriptions (Pédagogie)</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Étudiant</th>
                <th>Formation</th>
                <th>Validation Admin</th>
                <th>Validation Pédagogique</th>
                <th>État</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscriptions as $inscription)
            <tr>
                <td>{{ $inscription->etudiant->name }}</td>
                <td>{{ $inscription->formation->titre }}</td>
                <td class="text-center">
                    @if($inscription->valide_admin)
                        <span class="badge bg-success">Validé</span>
                    @else
                        <span class="badge bg-warning text-dark">En attente</span>
                    @endif
                </td>
                <td class="text-center">
                    @if(!$inscription->valide_pedagogique)
                        <form action="{{ route('pedagogique.valider.pedagogique', $inscription->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Valider</button>
                        </form>
                        <form action="{{ route('pedagogique.refuser.pedagogique', $inscription->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Êtes-vous sûr de vouloir refuser cette inscription ?')">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Refuser</button>
                        </form>
                    @else
                        <span class="badge bg-success">Validé</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($inscription->valide_admin && $inscription->valide_pedagogique)
                        <span class="badge bg-primary">Validée</span>
                    @elseif(!$inscription->valide_admin && !$inscription->valide_pedagogique)
                        <span class="badge bg-secondary">En attente</span>
                    @elseif($inscription->valide_admin && !$inscription->valide_pedagogique)
                        <span class="badge bg-warning text-dark">Validation pédagogique requise</span>
                    @elseif(!$inscription->valide_admin && $inscription->valide_pedagogique)
                        <span class="badge bg-warning text-dark">Validation admin requise</span>
                    @endif
                </td>
            </tr>
            @endforeach

            @if($inscriptions->isEmpty())
            <tr>
                <td colspan="5" class="text-center">Aucune inscription trouvée.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection