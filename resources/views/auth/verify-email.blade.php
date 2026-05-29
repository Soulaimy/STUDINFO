<x-guest-layout>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center"
     style="background: linear-gradient(135deg, #6D28D9, #A855F7, #EC4899); padding: 20px;">

    <div class="w-100" style="max-width: 460px;">

        <div class="card shadow-lg border-0 p-4 rounded-4 text-center">

            <h2 class="fw-bold mb-3">
                Vérification email
            </h2>

            <p class="text-muted small mb-4">
                Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.
                Si vous n’avez rien reçu, vous pouvez en demander un nouveau.
            </p>

            <!-- Status message -->
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success py-2 small">
                    Un nouveau lien de vérification a été envoyé à votre email.
                </div>
            @endif

            <!-- Resend email -->
            <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                @csrf

                <button type="submit" class="btn btn-dark w-100 fw-bold">
                    Renvoyer l’email de vérification
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-outline-dark w-100">
                    Se déconnecter
                </button>
            </form>

        </div>

    </div>

</div>

</x-guest-layout>
