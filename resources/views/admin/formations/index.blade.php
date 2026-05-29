@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"> Liste des formations</h2>

    <a href="{{ route('admin.formations.create') }}" class="btn btn-primary btn-sm mb-3">
        + Ajouter une formation
    </a>

    <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Titre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($formations as $formation)
                <tr>
                    <td>{{ $formation->titre }}</td>
                    <td>
                        <a href="{{ route('admin.formations.edit', $formation) }}" class="btn btn-sm btn-warning me-1">
                             Modifier
                        </a>

                        <form action="{{ route('admin.formations.destroy', $formation) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Voulez-vous vraiment supprimer cette formation ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"> Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-muted">Aucune formation pour le moment.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $formations->links() }}
    </div>
</div>
@endsection