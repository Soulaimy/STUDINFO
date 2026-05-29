@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-12 col-lg-8">

            <h1 class="mb-4 fw-bold text-center">
                Mon Profil
            </h1>

            <div class="card shadow border-0 rounded-4 p-4">

                <form action="{{ route('etudiant.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- Nom -->
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- Email (READONLY au lieu de disabled) -->
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   value="{{ $user->email }}"
                                   class="form-control bg-light"
                                   readonly>
                        </div>

                        <!-- Département -->
                        <div class="col-md-6">
                            <label class="form-label">Département</label>
                            <input type="text"
                                   name="departement"
                                   value="{{ old('departement', $user->departement) }}"
                                   class="form-control">
                        </div>

                        <!-- Ville -->
                        <div class="col-md-6">
                            <label class="form-label">Ville</label>
                            <input type="text"
                                   name="ville"
                                   value="{{ old('ville', $user->ville) }}"
                                   class="form-control">
                        </div>

                        <!-- Date naissance -->
                        <div class="col-md-6">
                            <label class="form-label">Date de naissance</label>
                            <input type="date"
                                   name="date_naissance"
                                   value="{{ old('date_naissance', $user->date_naissance) }}"
                                   class="form-control">
                        </div>

                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary px-4">
                            Enregistrer
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection