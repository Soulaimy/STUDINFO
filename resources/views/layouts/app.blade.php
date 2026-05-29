<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        .top-nav {
            background-color: #0d1b2a;
            color: white;
            padding: 0 2rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 50;
            display: flex;
            align-items: center;
            height: 64px;
        }

        .top-nav a {
            color: white;
            margin-right: 1.5rem;
            text-decoration: none;
            font-weight: 500;
        }

        .top-nav a:hover {
            text-decoration: underline;
        }

        /* Supprime tout padding ou margin parasite */
        .second-nav {
    margin: 0;
}
    </style>
</head>

<body class="font-sans antialiased bg-white">

    <nav class="top-nav">
         <!-- Logo -->
    <a href="{{ url('/') }}">
        <img src="https://www.intedgroup.com/wp-content/uploads/2023/08/Group-38.png" alt="Logo" width="120" height="40">
    </a>

        <a href="{{ url('/') }}">Accueil</a>
        <a href="#formations">Formations</a>
        <a href="{{ url('/#contact') }}">Contact</a>
    </nav>

    <div class="second-nav">
        @include('layouts.navigation')
    </div>

    @hasSection('header')
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('header')
            </div>
        </header>
    @endif

    <main style="padding-top: 150px;">
       @yield('content')
    </main>

    <!-- cookies-->
    <div id="cookie-banner" style="position:fixed; bottom:0; width:100%; background:#222; color:white; padding:15px; text-align:center; display:none; z-index:9999;">
    Ce site utilise des cookies pour améliorer votre expérience.
    
    <button onclick="acceptCookies()" style="margin-left:10px; background:green; color:white;">Accepter</button>
    
    <button onclick="refuseCookies()" style="margin-left:10px; background:red; color:white;">Refuser</button>
</div>

<script>
function acceptCookies() {
    localStorage.setItem('cookiesChoice', 'accepted');
    document.getElementById('cookie-banner').style.display = 'none';
}

function refuseCookies() {
    localStorage.setItem('cookiesChoice', 'refused');
    document.getElementById('cookie-banner').style.display = 'none';
}

window.onload = function() {
    const choice = localStorage.getItem('cookiesChoice');

    if (!choice) {
        document.getElementById('cookie-banner').style.display = 'block';
    }

    if (choice === 'refused') {
        console.log("Cookies refusés");
    }

    if (choice === 'accepted') {
        console.log("Cookies acceptés");
    }
}
</script>

    
    <!-- Bootstrap 5 (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-...TON_HASH..." crossorigin="anonymous"></script>
</body>
</html>