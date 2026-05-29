<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
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
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/[a-z]/',// au moins une lettre minuscule
            'regex:/[A-Z]/',// au moins une lettre majuscule
            'regex:/[0-9]/',// au moins un chiffre
            'regex:/[\W_]/',// au moins un caractère spécial
        ],
    ]);

    // Création de l'utilisateur
  $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => 'etudiant', // ICI on met le rôle etudiant par defaut
]);

    // Attribution du rôle étudiant
    event(new Registered($user));
    Auth::login($user);

    return redirect()->route('etudiant.formations');
}

}