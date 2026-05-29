@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Liste des formations</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Nombre d'inscrits</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($formations as $formation)
                <tr>
                    <td>{{ $formation->titre }}</td>
                    <td>{{ $formation->inscriptions_count }}</td>
                    <td>
                        <a href="{{ route('pedagogique.formations.inscriptions', $formation->id) }}" 
                           class="btn btn-sm btn-info">
                            Voir les {{ $formation->inscriptions_count }} inscrit(s)
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Aucune formation trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $formations->links() }}
    </div>
</div>
@endsection