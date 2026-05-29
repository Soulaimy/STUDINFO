@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">
         Liste des Formations
        <a href="{{ route('admin.formations.create') }}" class="btn btn-primary btn-sm float-end">
            + Ajouter une formation
        </a>
    </h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($formations->isEmpty())
        <p class="text-muted">Aucune formation n’a été ajoutée pour le moment.</p>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Durée (h)</th>
                    <th>Ajouté le</th>
                    <th>Actions</th> {{-- Ajout de la colonne Actions --}}
                </tr>
            </thead>
            <tbody>
                @foreach($formations as $formation)
                    <tr>
                        <td>{{ $formation->id }}</td>
                        <td>{{ $formation->titre }}</td>
                        <td>{{ Str::limit($formation->description, 50) }}</td>
                        <td>{{ $formation->duree }}</td>
                        <td>{{ $formation->created_at->format('d/m/Y') }}</td>

                        {{-- Boutons Modifier / Supprimer --}}
                        <td>
                            <a href="{{ route('admin.formations.edit', $formation) }}" class="btn btn-sm btn-warning">
                                 Modifier
                            </a>

                            <form action="{{ route('admin.formations.destroy', $formation) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cette formation ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑 Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        {{ $formations->links() }}
    @endif
</div>
@endsection