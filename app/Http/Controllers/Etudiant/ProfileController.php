<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Affiche l’espace profil de l’étudiant
     */
    public function index()
    {
        $user = Auth::user();

        // Historique des candidatures
        $inscriptions = $user->inscriptions()->with('formation')->get();

        return view('etudiant.profile', compact('user', 'inscriptions'));
    }
    

    //modifier les informations du profil aussi dans la base de donnée
    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'departement' => 'required|string',
        'ville' => 'required|string',
        'date_naissance' => 'required|date',
    ]);

    

    return redirect()->back()->with('success', 'Informations mises à jour avec succès.');
}
}
