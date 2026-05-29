@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Inscriptions à valider pédagogiquement</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Étudiant</th>
                <th>Formation</th>
                <th>Date</th>
                <th>Admin Validé</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscriptions as $inscription)
                <tr>
                    <td>{{ $inscription->etudiant->name ?? 'N/A' }}</td>
                    <td>{{ $inscription->formation->nom ?? 'N/A' }}</td>
                    <td>{{ $inscription->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($inscription->valide_admin)
                            ✅
                        @else
                            ❌
                        @endif
                    </td>
                    <td>
                        @if(!$inscription->valide_pedagogique)
                            @if($inscription->valide_admin)
                                <form action="{{ route('pedagogique.inscription.valider', $inscription->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Valider</button>
                                </form>
                            @endif
                            <form action="{{ route('pedagogique.inscription.refuser', $inscription->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Confirmer le refus ?');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Refuser</button>
                            </form>
                        @else
                            <span class="badge bg-success">Validée</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucune inscription à afficher.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
