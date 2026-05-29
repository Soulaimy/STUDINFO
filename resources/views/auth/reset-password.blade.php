<x-guest-layout>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center"
     style="background: linear-gradient(135deg, #6D28D9, #A855F7, #EC4899); padding: 20px;">

    <div class="w-100" style="max-width: 420px;">

        <div class="card shadow-lg border-0 p-4 rounded-4">

            <h2 class="text-center mb-4 fw-bold">
                Nouveau mot de passe
            </h2>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $request->email) }}"
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
                           required autocomplete="new-password">

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm -->
                <div class="mb-3">
                    <label class="form-label">Confirmation</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           required autocomplete="new-password">

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-dark w-100 fw-bold py-2">
                    Réinitialiser le mot de passe
                </button>

            </form>

        </div>

    </div>

</div>

</x-guest-layout>
