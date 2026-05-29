@extends('layouts.app')

@section('content')
<div class="container-fluid bg-light py-5 d-flex justify-content-center" style="min-height: calc(100vh - 70px);">
    <div class="card shadow p-4 w-100" style="max-width: 1300px; border-radius: 15px;">
        <h2 class="text-center mb-4">
            <i class="fas fa-clipboard-list me-2"></i>Gestion des Inscriptions
        </h2>

        <ul class="nav nav-tabs mb-4" id="inscriptionsTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="en-attente-tab" data-bs-toggle="tab" data-bs-target="#en-attente" type="button" role="tab" aria-controls="en-attente" aria-selected="true">
            En attente <span class="badge bg-warning text-dark">{{ $enAttente->count() }}</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="validees-tab" data-bs-toggle="tab" data-bs-target="#validees" type="button" role="tab" aria-controls="validees" aria-selected="false">
            Validées <span class="badge bg-success">{{ $validees->count() }}</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="refusees-tab" data-bs-toggle="tab" data-bs-target="#refusees" type="button" role="tab" aria-controls="refusees" aria-selected="false">
            Refusées <span class="badge bg-danger">{{ $refusees->count() }}</span>
        </button>
    </li>
</ul>

<div class="tab-content" id="inscriptionsTabContent">
    <div class="tab-pane fade show active" id="en-attente" role="tabpanel" aria-labelledby="en-attente-tab">
        @include('admin.inscriptions.partials.table', ['inscriptions' => $enAttente])
    </div>

    <div class="tab-pane fade" id="validees" role="tabpanel" aria-labelledby="validees-tab">
        @include('admin.inscriptions.partials.table', ['inscriptions' => $validees])
    </div>

    <div class="tab-pane fade" id="refusees" role="tabpanel" aria-labelledby="refusees-tab">
        @include('admin.inscriptions.partials.table', ['inscriptions' => $refusees])
    </div>
</div>
    </div>
</div>
@endsection