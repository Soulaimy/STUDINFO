@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 120px);">

    <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 520px;">
        <div class="card-body p-4 p-md-5">

            <h3 class="text-center fw-bold mb-3">
                Paiement
            </h3>

            <p class="text-center text-muted mb-1">
                Formation : <strong>{{ $inscription->formation->titre }}</strong>
            </p>

            <p class="text-center mb-4">
                Montant :
                <span class="badge bg-success fs-6 px-3 py-2">550 €</span>
            </p>

            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('etudiant.paiement.process', $inscription->id) }}" method="POST" id="paymentForm" autocomplete="off">
                @csrf

                <!-- Carte -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Numéro de carte</label>
                    <input type="text"
                        class="form-control form-control-lg"
                        id="card_number"
                        name="card_number"
                        placeholder="XXXX XXXX XXXX XXXX"
                        maxlength="19"
                        required
                        value="{{ old('card_number') }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Expiration</label>
                        <input type="text"
                            class="form-control form-control-lg"
                            id="expiry"
                            name="expiry"
                            placeholder="MM/AA"
                            maxlength="5"
                            required
                            value="{{ old('expiry') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">CVV</label>
                        <input type="text"
                            class="form-control form-control-lg"
                            id="cvv"
                            name="cvv"
                            placeholder="123"
                            maxlength="4"
                            required
                            value="{{ old('cvv') }}">
                    </div>
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('etudiant.inscriptions') }}" class="btn btn-outline-secondary">
                        ← Retour
                    </a>

                    <button type="submit" class="btn btn-success px-4">
                        Payer
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

<!-- Script inchangé -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cardInput = document.getElementById('card_number');
    const expiryInput = document.getElementById('expiry');
    const cvvInput = document.getElementById('cvv');
    const form = document.getElementById('paymentForm');

    cardInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '').slice(0,19);
        let groups = [];
        for (let i = 0; i < value.length; i += 4) {
            groups.push(value.substr(i, 4));
        }
        this.value = groups.join(' ');
    });

    expiryInput.addEventListener('input', function() {
        let v = this.value.replace(/[^\d]/g, '').slice(0,4);
        if (v.length >= 3) {
            v = v.slice(0,2) + '/' + v.slice(2);
        }
        this.value = v;
    });

    cvvInput.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0,4);
    });

    form.addEventListener('submit', function(e) {
        const expiry = expiryInput.value;
        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {
            e.preventDefault();
            alert('Format MM/AA requis');
            return;
        }
    });
});
</script>

@endsection