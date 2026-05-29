@extends('layouts.app')

@section('content')

<style>
    .formulaire-inscription {
        max-width: 700px;
        margin: 50px auto;
        background-color: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .formulaire-inscription h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #0d6efd;
    }

    .formulaire-inscription .form-label {
        font-weight: bold;
    }

    .btn-submit {
        width: 100%;
        margin-top: 25px;
        padding: 12px;
        font-size: 16px;
        font-weight: 600;
        background-color: #0d6efd;
        color: white;
        border: none;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #0c2142;
        color: white;
    }
</style>

<div class="formulaire-inscription">
    <h2>Inscription à la formation : {{ $formation->nom }}</h2>

    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Affichage des erreurs --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form  method="POST" enctype="multipart/form-data" action="{{ route('etudiant.inscription.submit', $formation->id) }}">
        @csrf

        <select name="rentree_id">
          @foreach(\App\Models\Rentree::all() as $rentree)
         <option value="{{ $rentree->id }}">
            Session {{ $rentree->annee }} ({{ $rentree->date_debut }} → {{ $rentree->date_fin }})
        </option>
       @endforeach
   </select>
        <!-- Département -->
        <div class="mb-3">
            <label for="departement" class="form-label">Département</label>
            <input type="text" class="form-control" id="departement" name="departement" value="{{ old('departement') }}" required>
        </div>

        <!-- Ville -->
        <div class="mb-3">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville" value="{{ old('ville') }}" required>
        </div>

        <!-- Date de naissance -->
        <div class="mb-3">
            <label for="date_naissance" class="form-label">Date de naissance</label>
            <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}" required>
        </div>
        
        <!-- Nom du diplôme obtenu -->
        <div class="mb-3">
          <label class="form-label">Nom du dernier diplôme obtenu</label><br/>

          <input type="radio" name="nom_diplome" value="Baccalauréat" />
            <label>Baccalauréat</label> <br/>

            <input type="radio" name="nom_diplome" value="Bac+1" />
            <label>BAC+1</label> <br/>

            <input type="radio" name="nom_diplome" value="Bac+2" />
            <label>BAC+2</label> <br/>

           <input type="radio" name="nom_diplome" value="BTS" />
           <label>BTS</label> <br/>

           <input type="radio" name="nom_diplome" value="Licence" />
           <label>Licence</label> <br/>

           <input type="radio" name="nom_diplome" value="M1" />
           <label>M1</label> <br/>

            <input type="radio" name="nom_diplome" value="Master" />
          <label>MASTER</label> <br/>
        </div>
        
        


        <!-- Moyenne -->
        <div class="mb-3">
            <label for="moyenne" class="form-label">Moyenne obtenue</label>
            <input type="number" step="0.01" min="0" max="20" class="form-control" id="moyenne" name="moyenne" value="{{ old('moyenne') }}" required>
        </div>

        <!-- Carte d'identité -->
        <div class="mb-3">
            <label for="carte_identite" class="form-label">Carte d'identité (PDF ou image)</label>
            <input type="file" class="form-control" id="carte_identite" name="carte_identite" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>

        <!-- Diplôme -->
        <div class="mb-3">
            <label for="diplome" class="form-label">Dernier diplôme (PDF ou image)</label>
            <input type="file" class="form-control" id="diplome" name="diplome" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>

        <!-- Signature électronique -->
    <div class="mb-4">
         <label class="form-label fw-bold">Signature électronique</label>

        <div class="border rounded p-3 bg-white">
           <canvas id="signature-pad" width="600" height="200" 
                style="border: 2px solid #0d6efd; border-radius: 8px; cursor: crosshair;">
           </canvas>

          <div class="mt-3 d-flex gap-2">
            <button type="button" id="clear-signature" class="btn btn-warning btn-sm">
                Effacer la signature
            </button>
          </div>
        </div>

      <!-- Champ caché qui recevra l'image -->
       <input type="hidden" name="signature" id="signature-input">
    </div>

        <!-- Soumettre -->
        <button type="submit" class="btn-submit"> Soumettre l'inscription</button>
    </form>
</div>
<script>
    const canvas = document.getElementById("signature-pad");
    const ctx = canvas.getContext("2d");

    let drawing = false;

    function getPosition(event) {
        const rect = canvas.getBoundingClientRect();
        return {
            x: event.clientX - rect.left,
            y: event.clientY - rect.top
        };
    }

    canvas.addEventListener("mousedown", (e) => {
        drawing = true;
        const pos = getPosition(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    });

    canvas.addEventListener("mousemove", (e) => {
        if (!drawing) return;
        const pos = getPosition(e);
        ctx.lineWidth = 2;
        ctx.lineCap = "round";
        ctx.strokeStyle = "#000";
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    });

    canvas.addEventListener("mouseup", () => drawing = false);
    canvas.addEventListener("mouseleave", () => drawing = false);

    // Effacer
    document.getElementById("clear-signature").addEventListener("click", () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    // Convertir en image avant envoi
    document.querySelector("form").addEventListener("submit", function () {
        document.getElementById("signature-input").value = canvas.toDataURL("image/png");
    });
</script>


@endsection