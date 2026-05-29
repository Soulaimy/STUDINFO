@extends('layouts.app')

@section('content')

<style>
    .container-formations {
        max-width: 960px;
        margin: 40px auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .card-formation {
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        width: 30%;
        min-width: 280px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: box-shadow 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .card-formation:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .card-formation h5 {
        color: #0d6efd;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .toggle-icon {
        font-size: 18px;
        font-weight: bold;
        margin-left: 10px;
        color: #333;
    }

    .card-formation p {
        margin-bottom: 12px;
        color: #333;
        font-size: 14px;
    }

    .btn-inscrire {
        background-color: #0d6efd;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px 15px;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s ease;
        display: block;
        margin-top: 10px;
    }

    .btn-inscrire:hover {
        background-color: #0b5ed7;
        color: white;
    }

    .btn-inscrire.disabled {
        background-color: #ccc;
        color: #666;
        cursor: not-allowed;
        pointer-events: none;
    }

    .description-cachee {
        display: none;
        margin-top: 10px;
        font-size: 13px;
        color: #555;
    }

    .description-cachee.active {
        display: block;
    }

    .titre-section {
        text-align: center;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 30px;
        color: #0d6efd;
    }
</style>

<div class="container">
    <div class="titre-section">
         Voici les formations disponibles, veuillez choisir la formation
    </div>

   <div class="container-formations">
    @foreach ($formations as $formation)
    <div class="card-formation">
    <h5 onclick="toggleDescription({{ $formation->id }})">
        {{ $formation->titre }}
        <span class="toggle-icon" id="icon-{{ $formation->id }}">+</span>
    </h5>

    <p><strong>Durée :</strong> {{ $formation->duree }} heures</p>

    <div id="desc-{{ $formation->id }}" class="description-cachee">
        {{ $formation->description }}
    </div>

    @if (!empty($inscriptions) && in_array($formation->id, $inscriptions))
        <span class="btn-inscrire disabled">Déjà inscrit</span>
    @else
        <form method="POST" action="{{ route('etudiant.inscription.creer', $formation->id) }}">
            @csrf

            <select name="rentree_id" class="form-control" required>
                @foreach(\App\Models\Rentree::all() as $rentree)
                    <option value="{{ $rentree->id }}">
                        Rentrée {{ $rentree->annee }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn-inscrire">S’inscrire</button>
        </form>
    @endif
</div>
@endforeach
</div>
</div>

<script>
    function toggleDescription(id) {
        const allDescriptions = document.querySelectorAll('.description-cachee');
        const allIcons = document.querySelectorAll('.toggle-icon');

        allDescriptions.forEach(desc => {
            if (desc.id !== 'desc-' + id) {
                desc.classList.remove('active');
            }
        });

        allIcons.forEach(icon => {
            if (icon.id !== 'icon-' + id) {
                icon.textContent = '+';
            }
        });

        const description = document.getElementById('desc-' + id);
        const icon = document.getElementById('icon-' + id);

        if (description.classList.contains('active')) {
            description.classList.remove('active');
            icon.textContent = '+';
        } else {
            description.classList.add('active');
            icon.textContent = '–';
        }
    }
</script>

@endsection