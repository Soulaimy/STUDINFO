<nav class="navbar navbar-expand-lg navbar-light border-bottom shadow-sm fixed-top" style="top:64px; background:white; z-index:40;">
        <div class="container">

        <!-- Bouton mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav2">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse show" id="nav2">

            <!-- Liens gauche -->
            <ul class="navbar-nav me-auto">

                @auth
                    @php
                        $user = Auth::user();
                        $role = $user->role;
                        $hasInscription = false;
                        if ($role === 'etudiant') {
                            $hasInscription = $user->inscriptions()->exists();
                        }
                    @endphp

                    @if ($role === 'etudiant' && !$hasInscription)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                    @endif

                    @if ($role === 'etudiant')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('etudiant.espace') }}">Espace Étudiant</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('etudiant.profil') }}">Mon Profil</a>
                        </li>

                    @elseif ($role === 'responsable administratif')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.formations') }}">Formations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Espace Administratif</a>
                        </li>
                        @if (Route::has('admin.inscriptions'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.inscriptions') }}">Inscriptions</a>
                        </li>
                        @endif

                    @elseif ($role === 'responsable pedagogique')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pedagogique.espace') }}">Pédagogie</a>
                        </li>
                    @endif

                @endauth

            </ul>

            <!-- Droite -->
            <ul class="navbar-nav ms-auto">

                @auth
                    <li class="nav-item">
                        <span class="nav-link">{{ Auth::user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-danger">
                                Déconnexion
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                    </li>
                @endauth

            </ul>

        </div>
    </div>
</nav>