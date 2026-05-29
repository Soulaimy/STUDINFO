<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inscription;

class PaiementController extends Controller
{
    public function show($inscriptionId)
    {
        // Récupérer l'inscription, avec la formation liée
        $inscription = Inscription::with('formation')
                        ->where('id', $inscriptionId)
                        ->where('user_id', auth()->id()) // sécurité : uniquement son inscription
                        ->firstOrFail();

        return view('etudiant.paiement', compact('inscription'));
    }

    public function process(Request $request, $inscriptionId)
    {
        // Logique de traitement du paiement ici

        // Exemple : marquer paiement comme effectué
        $inscription = Inscription::where('id', $inscriptionId)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();

        // Ajoute un champ 'paiement_effectue' dans ta table inscriptions, ici en exemple
        $inscription->paiement_effectue = true;
        $inscription->save();

        return redirect()->route('etudiant.inscriptions')->with('success', 'Paiement effectué avec succès.');
    }
}
