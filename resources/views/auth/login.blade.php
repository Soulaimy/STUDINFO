<x-guest-layout>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center"
     style="background: linear-gradient(135deg, #6D28D9, #A855F7, #EC4899); padding: 20px;">

    <div class="w-100" style="max-width: 420px;">

        <div class="card shadow-lg border-0 p-4 rounded-4">

            <h2 class="text-center mb-4 fw-bold">
                Connexion
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
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

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           required autocomplete="current-password">

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember -->
                <div class="form-check mb-3">
                    <input id="remember_me"
                           type="checkbox"
                           name="remember"
                           class="form-check-input">

                    <label class="form-check-label" for="remember_me">
                        Se souvenir de moi
                    </label>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between align-items-center">

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-decoration-none small">
                            Mot de passe oublié ?
                        </a>
                    @endif

                    <button type="submit" class="btn btn-dark px-4">
                        Connexion
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</x-guest-layout>