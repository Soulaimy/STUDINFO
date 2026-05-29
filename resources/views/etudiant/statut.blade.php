@extends('layouts.app')
@section('content')
<h2>Statut de mes inscriptions</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Formation</th>
            <th>État Administratif</th>
            <th>État Pédagogique</th>
            <th>Paiement</th>
        </tr>
    </thead>
    <tbody>
        @foreach($inscriptions as $inscription)
        <tr>
            <td>{{ $inscription->formation->titre }}</td>
            <td>{{ $inscription->etat_admin }}</td>
            <td>{{ $inscription->etat_pedagogique }}</td>
            <td>{{ $inscription->paiement_effectue ? 'Effectué' : 'Non effectué' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
