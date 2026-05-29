@extends('layouts.app')

@section('content')

<style>
body {
    scroll-behavior: smooth;
}

/* BANNIÈRE */
.header-banner {
    background: url('https://www.onisep.fr/var/onisep/storage/images/4/3/5/4/34674534-1-fre-FR/2d9dee076c22-Etats-Unis_iStock-896458598.jpg') center center no-repeat;
    background-size: cover;
    color: white;
    padding: 200px 0;
    text-align: center;
    position: relative;
}
.overlay {
    position: absolute;
    top:0; left:0; right:0; bottom:0;
    background: rgba(0,0,0,0.4);
}
.header-text {
    position: relative;
    z-index: 2;
}
.btn-inscription {
    background-color: #033972;
    color: white;
    padding: 10px 25px;
    border-radius: 5px;
}
.btn-inscription:hover {
    background-color: #630404;
}

/* STATS */
.stats {
    background: #001f3f;
    color: white;
    padding: 18px;
    text-align: center;
}
.stats div {
    margin-bottom: 10px;
}

/* FORMATIONS */
.card img {
    height: 150px;
    object-fit: cover;
}
</style>

{{-- BANNIÈRE --}}
<div class="header-banner" id="acceuil">
    <div class="overlay"></div>
    <div class="header-text">
        <h1>Bienvenue à Studinfo</h1>
        <h2>Transformez votre passion en carrière avec des formations d’avenir en informatique.</h2>

        @guest
        <a href="{{ route('register') }}" class="btn btn-primary btn-inscription">
            S'inscrire
        </a>
        @endguest
    </div>
</div>

{{-- STATS --}}
<div class="container-fluid stats" id="formations">
    <div class="row">
        <div class="col"><strong>8k</strong><br>Places/an</div>
        <div class="col"><strong>20k</strong><br>Étudiants</div>
        <div class="col"><strong>6k</strong><br>Étrangers</div>
        <div class="col"><strong>5k</strong><br>Diplômés</div>
    </div>
</div>

{{-- FORMATIONS --}}
<div class="container mt-5" >
    <div class="row">

        @php
            $defaultImages = [
                'https://images.unsplash.com/photo-1640163561336-ff3be443f5ce?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8aW5mb3JtYXRpcXVlJTIwZXR1ZGlhbnR8ZW58MHx8MHx8fDA%3D',
                'https://media.istockphoto.com/id/2187408419/fr/photo/tablette-bureau-et-femme-noire-en-affaires-la-nuit-pour-rechercher-ou-examiner-la-conception.webp?a=1&b=1&s=612x612&w=0&k=20&c=HE7tPVLvxzEW2NS-QTo3Fb9WVNztYAUkI74EiweY_pA=',
                'https://media.istockphoto.com/id/1363276509/fr/photo/un-enseignant-donne-une-conf%C3%A9rence-en-informatique-%C3%A0-un-groupe-multiethnique-diversifi%C3%A9.webp?a=1&b=1&s=612x612&w=0&k=20&c=rAcaFsgGApGkvPLR5W3cA-Csfy0_fF9e_IRZz-MGBVo=',
                'https://media.istockphoto.com/id/1458679628/fr/photo/vue-ci-dessus-de-lapprentissage-en-ligne-des-%C3%A9tudiants-sur-des-ordinateurs-dans-la-salle-de.webp?a=1&b=1&s=612x612&w=0&k=20&c=zTz1nqJ_93YTyvqF4rZtI6fgS3Es4rc8oOBsydlxfZo=',
                'https://media.istockphoto.com/id/1071467916/fr/photo/groupe-de-jeunes-%C3%A9tudiants-travaillant-sur-une-cession.webp?a=1&b=1&s=612x612&w=0&k=20&c=qXsdaXwPHlqq0UfLaWm2zqJHoxXFpGOaQJphC5zIgNE=',
                'https://images.unsplash.com/photo-1758270704464-f980b03b9633?q=80&w=1331&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'https://images.unsplash.com/photo-1752650735506-befbb7049252?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NDF8fGluZm9ybWF0aXF1ZSUyMGV0dWRpYW50fGVufDB8fDB8fHww',
                'https://images.unsplash.com/photo-1723987135977-ae935608939e?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NjF8fGluZm9ybWF0aXF1ZSUyMGV0dWRpYW50fGVufDB8fDB8fHww',
                'https://images.unsplash.com/photo-1758685848440-1ba62a19154e?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTkxfHxpbmZvcm1hdGlxdWUlMjBldHVkaWFudHxlbnwwfHwwfHx8MA%3D%3D',
                'https://images.unsplash.com/photo-1551434678-e076c223a692',
              ];
        @endphp

        @forelse($formations as $formation)

        @php
        $imageUrl = !empty($formation->image)
            ? asset('storage/formations/' . $formation->image)
            : $defaultImages[array_rand($defaultImages)];
        @endphp

         <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div x-data="{ open: false }" class="card shadow h-100">

                    <img src="{{ $imageUrl }}"
                         class="card-img-top" style="height:150px; object-fit:cover;" alt="{{ $formation->titre }}">

                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title text-truncate" title="{{ $formation->titre }}">
                            {{ $formation->titre ?? 'Formation sans titre' }}
                        </h5>

                        <button @click="open = !open"
                                class="btn btn-link p-0 text-start text-primary">
                            Voir les détails
                        </button>

                        <div x-show="open" x-transition class="mt-2 small text-muted">
                            <p><strong>Introduction :</strong> {{ Str::limit($formation->description, 300, '...') }}</p>
                            <p><strong>Durée :</strong> {{ $formation->duree ?? 'N/A' }} heures</p>
                        </div>

                        @guest
                            <a href="{{ route('register') }}"
                               class="btn btn-primary mt-auto w-100">
                                S’inscrire
                            </a>
                        @endguest

                    </div>
                </div>
            </div>

        @empty
            <p class="text-center w-100 text-muted">
                Aucune formation disponible pour le moment.
            </p>
        @endforelse

    </div>
</div>
{{-- CONTACT --}}
<footer id="contact" class="bg-dark text-white text-center p-4 mt-5">
    <h4>Contact</h4>
    <p>Téléphone : (+33) 7 81 97 43 19</p>
    <p>Email : contact@studinfo.com</p>
    <p>© 2025 Studinfo</p>
</footer>

@endsection