<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;

class InscriptionController extends Controller
{
    // Middleware pour restreindre l'accès selon les rôles (à adapter selon ta gestion)
    public function __construct()
    {
        $this->middleware('auth');
        // Par exemple, middleware pour les rôles pédagogiques/admins ici
    }

    /**
     * Affiche la liste des inscriptions pour le rôle pédagogique
     */
    public function indexPedagogique()
    {
        // Récupère toutes les inscriptions avec leurs relations étudiante et formation
        $inscriptions = Inscription::with(['etudiant', 'formation'])->get();

        return view('pedagogique.inscriptions', compact('inscriptions'));
    }

    /**
     * Valider une inscription côté pédagogique
     */
    public function validerPedagogique($id)
    {
        $inscription = Inscription::findOrFail($id);

        // Valider uniquement si elle n'est pas déjà validée
        if (!$inscription->valide_pedagogique) {
            $inscription->valide_pedagogique = true;
            $inscription->save();
        }

        return redirect()->back()->with('success', 'Inscription validée avec succès.');
    }

    /**
     * Refuser une inscription côté pédagogique
     */
    public function refuserPedagogique($id)
    {
        $inscription = Inscription::findOrFail($id);

        // Ici, tu peux choisir soit de supprimer l'inscription soit de mettre un flag "refusée"
        // Exemple avec suppression :
        $inscription->delete();

        return redirect()->back()->with('success', 'Inscription refusée et supprimée.');
    }

    // Tu peux aussi avoir d'autres méthodes pour validation admin, gestion etc.
}