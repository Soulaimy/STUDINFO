<x-guest-layout>

    <div class="min-vh-100 d-flex align-items-center justify-content-center"
         style="background: linear-gradient(135deg, #6D28D9, #A855F7, #EC4899); padding: 20px;">

        <div class="w-100" style="max-width: 420px;">

            <div class="card shadow-lg border-0 p-4 rounded-4">

                <h2 class="text-center mb-4 fw-bold">
                    Créer un compte
                </h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nom -->
                    <div class="mb-3">
                        <label class="form-label">Nom complet</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <input type="hidden" name="role" value="etudiant">

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <!-- Requirements -->
                    <div id="password-requirements" class="small mb-3">
                        <p class="mb-1">Le mot de passe doit contenir :</p>
                        <ul class="list-unstyled">
                            <li id="length">• 8 caractères</li>
                            <li id="lowercase">• minuscule</li>
                            <li id="uppercase">• majuscule</li>
                            <li id="number">• chiffre</li>
                            <li id="special">• spécial</li>
                        </ul>
                    </div>

                    <!-- Confirm -->
                    <div class="mb-3">
                        <label class="form-label">Confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <!-- Button -->
                    <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">
                        S’inscrire
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            Déjà inscrit ?
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>

</x-guest-layout>