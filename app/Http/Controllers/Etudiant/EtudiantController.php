<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Inscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EtudiantController extends Controller
{
    // Espace personnel étudiant
    public function espace()
    {
        return view('etudiant.espace');
    }

    // Liste des formations disponibles
    public function formations()
{
    $user = Auth::user();
    $formations = Formation::all();

    // Liste des formations déjà demandées
    $inscriptions = $user->inscriptions()->pluck('formation_id')->toArray();

    // Vérifier si l'étudiant possède une inscription validée par admin + pédagogie
    $inscriptionValidee = $user->inscriptions()
        ->where('etat', 'valide')
        ->exists();

    return view('etudiant.formations', compact('formations', 'inscriptions', 'inscriptionValidee'));
}

    // Inscription à une formation (étape 1)
    public function inscrire(Request $request, $formationId)
{
    $request->validate([
        'rentree_id' => 'required|exists:rentrees,id',
    ]);
    $user = Auth::user();

    //  Empêche inscription si un dossier est déjà validé
    $inscriptionValidee = $user->inscriptions()
        ->where('etat', 'valide')
        ->exists();

    if ($inscriptionValidee) {
        return redirect()->back()->with('error', 'Votre dossier est déjà validé. Vous ne pouvez pas vous inscrire à une autre formation.');
    }

    // Vérifie si une inscription à cette formation existe déjà
    $exists = Inscription::where('user_id', $user->id)
        ->where('formation_id', $formationId)
        ->exists();

    if ($exists) {
        return redirect()->back()->with('error', 'Vous êtes déjà inscrit à cette formation.');
    }

    Inscription::create([
        'user_id' => $user->id,
        'formation_id' => $formationId,
        'rentree_id' => $request->rentree_id,
        'etat_admin' => 'en_attente',
        'etat_pedagogique' => 'en_attente',
        'paiement_effectue' => false,
    ]);

    return redirect()->route('etudiant.inscription.formulaire', $formationId);
}

    // Afficher le formulaire d'inscription détaillé (étape 2)
    public function afficherFormulaire($formationId)
    {
        $formation = Formation::findOrFail($formationId);
        return view('etudiant.inscription', compact('formation'));
    }

    // Soumettre le dossier d'inscription (étape 3)
    public function soumettreFormulaire(Request $request, $formationId)
{
    $user = Auth::user();

    // 1. Validation des données
    $validated = $request->validate([
        'departement' => 'required|string|max:255',
        'ville' => 'required|string|max:255',
        'date_naissance' => 'required|date',
        'nom_diplome' => 'required|string|max:255',
        'moyenne' => 'required|numeric|min:0|max:20',
        'carte_identite' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
        'diplome' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
    ]);

    //  2. Sauvegarder date_naissance dans USERS
    $user->update([
        'date_naissance' => $validated['date_naissance'],
        'ville' => $validated['ville'],
        'departement' => $validated['departement'],
    ]);

    //  3. Stockage fichiers
    $carteIdentitePath = $request->file('carte_identite')
    ->store('documents/carte_identite', 'public');

$diplomePath = $request->file('diplome')
    ->store('documents/diplomes', 'public');
    

    //  4. Mise à jour inscription (SANS date_naissance)
    $inscription = Inscription::where('user_id', $user->id)
    ->where('formation_id', $formationId)
    ->first();

if (!$inscription) {
    return back()->with('error', 'Inscription introuvable.');
}

$inscription->update([
            'nom_diplome' => $validated['nom_diplome'],
            'moyenne' => $validated['moyenne'],
            'carte_identite' => $carteIdentitePath,
            'diplome' => $diplomePath,
        ]);

    return redirect()->route('etudiant.espace')->with('success', 'Votre dossier a été soumis avec succès.');
}

    // Afficher les inscriptions de l'étudiant
    public function mesInscriptions()
    {
        $user = Auth::user();
        $inscriptions = $user->inscriptions()->with('formation')->get();

        $aFormationValidee = $inscriptions->contains(function ($inscription) {
            return $inscription->etat_admin === 'valide' && $inscription->etat_pedagogique === 'valide';
        });

        return view('etudiant.mes_inscriptions', compact('inscriptions', 'aFormationValidee'));
    }

    // Annuler une inscription
    public function annulerInscription($inscriptionId)
    {
        $user = Auth::user();

        $inscription = Inscription::where('id', $inscriptionId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $inscription->delete();

        return redirect()->route('etudiant.inscriptions')->with('success', 'Inscription annulée avec succès.');
    }

    // Méthode alternative (non utilisée ici)
    public function store(Request $request, $formationId)
    {
        $user = auth()->user();

        if ($user->formation_id) {
            return redirect()->back()->with('error', 'Vous êtes déjà inscrit à une formation.');
        }

        $user->formation_id = $formationId;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Inscription réussie !');
    }

    // Méthode alternative (non utilisée ici)
    public function formulaire($formation_id)
    {
        $formation = Formation::findOrFail($formation_id);
        return view('etudiant.formulaire', compact('formation'));
    }
}