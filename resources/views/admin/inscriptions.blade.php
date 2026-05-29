<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DemandeRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gère la requête d'inscription.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'in:etudiant,responsable administratif,responsable pedagogique'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Création de l'utilisateur avec statut "non validé"
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'valide' => false,
        ]);

        // Enregistrement de la demande de rôle
        DemandeRole::create([
            'user_id' => $user->id,
            'role_demande' => $request->role,
            'statut' => 'en attente',
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Redirection vers une page d’attente de validation
        return redirect()->route('attente.validation');
    }
    @if($inscription->paiement_effectue)
    <span class="badge bg-success">Payé</span>
@else
    <span class="badge bg-danger">Non payé</span>
@endif
}