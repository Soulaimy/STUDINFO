@extends('layouts.app')

@section('content')
<style>
    .admin-dashboard {
        background-color: #f5f8fc;
        min-height: 90vh;
        padding: 50px 15px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .dashboard-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 1000px;
        padding: 40px;
    }

    .dashboard-header h2 {
        font-weight: 700;
        color: #0d6efd;
    }

    .dashboard-header p {
        color: #666;
        font-size: 1rem;
        margin-top: 8px;
    }

    .card-stat {
        border: none;
        border-radius: 10px;
        background-color: #f1f4f9;
        transition: 0.3s ease;
    }

    .card-stat:hover {
        background-color: #e1ecff;
    }

    .card-stat h5 {
        color: #333;
    }

    .card-stat h3 {
        color: #0d6efd;
        font-weight: 800;
    }

    .quick-links .btn {
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 25px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 3px 6px rgba(0,0,0,0.08);
    }

    .btn-users {
        background-color: #198754;
        color: white;
    }

    .btn-formations {
        background-color: #0d6efd;
        color: white;
    }

    .btn-inscriptions {
        background-color: #fd7e14;
        color: white;
    }

    .btn-new {
        background-color: #6f42c1;
        color: white;
    }

    .btn-users:hover {
        background-color: #157347;
    }

    .btn-formations:hover {
        background-color: #0b5ed7;
    }

    .btn-inscriptions:hover {
        background-color: #e96b0b;
    }

    .btn-new:hover {
        background-color: #59359c;
    }

    .export-links .btn {
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 8px;
    }

    .alert-section {
        font-size: 1rem;
    }

    .alert-section span {
        font-weight: 600;
    }
    .dashboard-title {
    font-size: 2rem;
    font-weight: 800;
    color: #0d6efd;
}
</style>

<div class="admin-dashboard">
    <div class="dashboard-card">
        {{-- En-tête --}}
        <div class="dashboard-header mb-5 text-center">
    <h2 class="dashboard-title"> Tableau de bord – Administrateur</h2>
    <p>Vue d’ensemble de l’activité de la plateforme</p>
</div>

        {{-- Statistiques dynamiques --}}
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card card-stat h-100">
                    <div class="card-body">
                        <h5 class="card-title"> Utilisateurs</h5>
                        <h3>{{ $usersCount }}</h3>
                        <p class="text-muted">Total des utilisateurs inscrits</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stat h-100">
                    <div class="card-body">
                        <h5 class="card-title"> Formations</h5>
                        <h3>{{ $formationsCount }}</h3>
                        <p class="text-muted">Formations disponibles</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stat h-100">
                    <div class="card-body">
                        <h5 class="card-title"> Inscriptions</h5>
                        <h3>{{ $pendingInscriptions }}</h3>
                        <p class="text-muted">Inscriptions en attente</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Liens rapides --}}
        <div class="mb-5">
            <h4 class="mb-3"> Liens rapides</h4>
            <div class="d-flex flex-wrap gap-3 quick-links">
                <a href="{{ route('admin.formations') }}" class="btn btn-formations">Formations</a>
                <a href="{{ route('admin.inscriptions') }}" class="btn btn-inscriptions">Inscriptions</a>
                <a href="{{ route('admin.formations.create') }}" class="btn btn-new">+ Nouvelle formation</a>
            </div>
        </div>

        {{-- Alertes --}}
        @if($pendingInscriptions > 0)
            <div class="mb-5 alert-section">
                <h4 class="mb-3 text-danger"> Alertes</h4>
                <div class="alert alert-warning d-flex align-items-center">
                    <span class="me-2"></span>
                    <span>{{ $pendingInscriptions }} inscriptions récentes attendent votre validation !</span>
                </div>
            </div>
        @endif

        {{-- Export --}}
        <div class="mb-3">
            <h4 class="mb-3"> Export / Reporting</h4>
            <div class="d-flex flex-wrap gap-3 export-links">
                <a href="{{ route('admin.export.utilisateurs') }}" class="btn btn-outline-secondary"> Export utilisateurs</a>
                <a href="{{ route('admin.export.statistiques') }}" class="btn btn-outline-secondary"> Export statistiques</a>
            </div>
        </div>
    </div>
</div>
@endsection
