<x-guest-layout>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center"
     style="background: linear-gradient(135deg, #6D28D9, #A855F7, #EC4899); padding: 20px;">

    <div class="w-100" style="max-width: 420px;">

        <div class="card shadow-lg border-0 p-4 rounded-4">

            <h2 class="text-center mb-3 fw-bold">
                Mot de passe oublié
            </h2>

            <p class="text-muted text-center small mb-4">
                Entrez votre email et nous vous enverrons un lien de réinitialisation.
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control"
                           required autofocus>

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">
                    Envoyer le lien
                </button>

            </form>

        </div>

    </div>

</div>

</x-guest-layout>
