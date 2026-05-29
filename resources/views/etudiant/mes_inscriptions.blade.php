@extends('layouts.app')

@section('content')
<style>
    .inscriptions-container {
        background-color: #f9fbfd;
        min-height: 85vh;
        padding: 50px 15px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .inscriptions-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 900px;
        padding: 30px 40px;
    }

    h2 {
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 25px;
        text-align: center;
    }

    .alert-info-custom {
        background-color: #e7f1ff;
        color: #0d6efd;
        border-radius: 8px;
        padding: 15px 20px;
        font-size: 1rem;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
        font-size: 1rem;
    }

    thead tr th {
        background-color: #f1f4fb;
        color: #333;
        font-weight: 600;
        padding: 12px 20px;
        text-align: center;
        border-radius: 8px;
    }

    tbody tr {
        background-color: #fefefe;
        box-shadow: 0 2px 6px rgb(0 0 0 / 0.05);
        border-radius: 10px;
        transition: background-color 0.2s ease;
    }

    tbody tr:hover {
        background-color: #e9f1ff;
    }

    tbody td {
        padding: 15px 20px;
        text-align: center;
        vertical-align: middle;
    }

    tbody td.fw-semibold {
        font-weight: 600;
        color: #222;
        text-align: left;
    }

    .badge {
        font-size: 0.9rem;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
    }

    .badge-success {
        background-color: #198754;
        color: #fff;
    }

    .badge-info {
        background-color: #0dcaf0;
        color: #fff;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-outline-primary {
        border-radius: 25px;
        padding: 6px 18px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .btn-outline-danger {
        border-radius: 25px;
        padding: 6px 18px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: rgb(75, 64, 64);
        border-color: #dc3545;
    }

    .text-muted {
        font-style: italic;
        color: #777;
    }
</style>

<div class="inscriptions-container">
    <div class="inscriptions-card">
        <h2> Mes Inscriptions</h2>

        {{-- Alerts --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- No inscriptions --}}
        @if($inscriptions->isEmpty())
            <div class="alert alert-warning text-center">Aucune inscription pour le moment.</div>
        @else
            <div class="alert-info-custom">
                 Consultez ici l'état de vos inscriptions, le statut administratif et pédagogique, ainsi que votre situation de paiement.
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Formation</th>
                        <th>Statut de validation</th>
                        <th>Paiement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscriptions as $inscription)
                        <tr>
                            <td class="fw-semibold">{{ $inscription->formation->titre }}</td>

                            <td>
                                @if($inscription->etat === 'refuse')
                                  <span class="badge badge-danger text-dark">Inscription refusée</span>
                                  @elseif($inscription->valide_admin && $inscription->valide_pedagogique)
                                  <span class="badge badge-success">Validée (Admin & Pédagogique)</span>
                                  @elseif($inscription->valide_admin)
                                  <span class="badge badge-info">Validée par l'admin</span>
                                   @elseif($inscription->valide_pedagogique)
                                  <span class="badge badge-info">Validée pédagogique</span>
                                  @else
                                  <span class="badge badge-warning">En attente de validation</span>
                                @endif
                            </td>

                            <td>
                                @if($inscription->paiement_effectue)
                                    <span class="text-success fw-bold">Paiement effectué</span>
                                @else
                                    <span class="text-danger fw-bold">Non payé</span>
                                @endif
                            </td>

                            <td>
                                @if(!$inscription->paiement_effectue)
                                    {{-- Bouton paiement activé ou désactivé selon validation --}}
                                    <a 
                                        href="{{ $inscription->valide_admin && $inscription->valide_pedagogique ? route('etudiant.paiement.show', $inscription->id) : '#' }}" 
                                        class="btn btn-sm me-2"
                                        style="
                                            border-radius: 25px;
                                            padding: 6px 18px;
                                            font-weight: 600;
                                            transition: all 0.3s ease;
                                            color: white;
                                            text-decoration: none;
                                            background-color: {{ $inscription->valide_admin && $inscription->valide_pedagogique ? '#dc3545' : '#6c757d' }};
                                            pointer-events: {{ $inscription->valide_admin && $inscription->valide_pedagogique ? 'auto' : 'none' }};
                                            border: none;
                                            display: inline-block;
                                        "
                                    >
                                        Effectuer paiement
                                    </a>

                                    <form action="{{ route('etudiant.inscription.annuler', $inscription->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Confirmer annulation ?')">Annuler</button>
                                    </form>

                                    {{-- Message sous le bouton --}}
                                    <div style="margin-top: 5px; font-size: 0.9rem; color: {{ $inscription->valide_admin && $inscription->valide_pedagogique ? '#198754' : '#856404' }};">
                                        @if($inscription->valide_admin && $inscription->valide_pedagogique)
                                            Vous pouvez procéder au paiement de votre inscription.
                                        @else
                                            Vous pourrez payer les frais d'inscription une fois votre dossier accepté.
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">Inscription finalisée</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection