<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\DemandeRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidationCompteMail;
use App\Mail\RefusCompteMail;

class InscriptionController extends Controller
{
    /**
     * Affiche les inscriptions et les demandes de rôle dans l’espace admin
     */
    public function index()
{
    return view('admin.inscriptions.index', [
        'enAttente' => Inscription::where(function ($query) {
                $query->where('etat', '!=', 'refuse')
                      ->orWhereNull('etat');
            })
            ->where(function ($query) {
                $query->where('valide_admin', false)
                      ->orWhereNull('valide_admin')
                      ->orWhere('valide_pedagogique', false)
                      ->orWhereNull('valide_pedagogique');
            })
            ->get(),

        'validees' => Inscription::where('valide_admin', true)
            ->where('valide_pedagogique', true)
            ->where('etat', '!=', 'refuse')
            ->get(),

        'refusees' => Inscription::where('etat', 'refuse')->get(),
    ]);
}

    /**
     * Met à jour une inscription
     */
    public function update(Request $request, Inscription $inscription)
{
    $validatedData = $request->validate([
        'etat' => 'nullable|string',
        'paiement_effectue' => 'nullable|boolean',
        'rentree_id' => 'nullable|exists:rentrees,id',
    ]);

    $inscription->update([
        'etat' => $request->etat,
        'paiement_effectue' => $request->paiement_effectue,
        'rentree_id' => $request->rentree_id,
    ]);

    return redirect()->route('admin.inscriptions.index')
        ->with('success', 'Inscription mise à jour.');
}

/**
 * Valider une inscription côté administratif
 */
public function validerAdmin($id)
{
    $inscription = Inscription::findOrFail($id);

    \DB::transaction(function () use ($inscription) {
        // Étape 1 : Valider l'inscription actuelle
        $inscription->update([
            'valide_admin' => true,
            'admin_validator_id' => \Auth::id(),
            'date_validation_admin' => now(),
            'etat' => 'accepter', 
            
        ]);

        //  Étape 2 : Supprimer toutes les autres inscriptions du même étudiant
        \App\Models\Inscription::where('user_id', $inscription->user_id)
            ->where('id', '!=', $inscription->id)
            ->delete();
    });

    return redirect()->back()->with('success', 'Inscription validée et autres inscriptions supprimées.');
}

    /**
     * Refuser une inscription admin 
     */
    public function refuserAdmin($id)
    {
        $inscription = Inscription::findOrFail($id);
        $inscription->update(['etat' => 'refuse']);

        $etudiant = $inscription->etudiant;
        if ($etudiant) {
            Mail::to($etudiant->email)->send(new RefusCompteMail($etudiant));
        }

        return redirect()->back()->with('success', 'Inscription refusée avec succès.');
    }

    /**
     * Valider une inscription pédagogiquement
     */
    public function validerPedagogique($id)
    {
        $inscription = Inscription::findOrFail($id);

        if (!$inscription->valide_admin) {
            return redirect()->back()->with('error', 'Impossible de valider sans validation administrative.');
        }

        $inscription->update([
            'valide_pedagogique' => true,
            'pedagogique_validator_id' => Auth::id(),
            'date_validation_pedagogique' => now(),
            'etat' => 'valide',
        ]);

        $etudiant = $inscription->etudiant;
        if ($etudiant) {
            Mail::to($etudiant->email)->send(new ValidationCompteMail($etudiant));
        }

        return redirect()->back()->with('success', 'Validation pédagogique effectuée.');
    }

    /**
     * Supprimer une inscription
     */
    public function destroy($id)
    {
        $inscription = Inscription::findOrFail($id);
        $inscription->delete();

        return redirect()->back()->with('success', 'Inscription supprimée avec succès.');
    }


public function show($id)
{
    $inscription = Inscription::with(['formation', 'user', 'documents'])->findOrFail($id);

    $user = $inscription->user;

    return view('admin.etudiants.profil', compact('inscription', 'user'));
}            

    public function profil($id)
{
    $inscription = Inscription::with('formation','user')->findOrFail($id);

    $user = $inscription->user;

    return view('admin.etudiants.profil', compact('inscription','user'));
}

}