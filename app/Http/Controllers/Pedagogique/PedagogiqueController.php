<?php

namespace App\Http\Controllers\Pedagogique;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inscription;

class PedagogiqueController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:responsable pedagogique']);
    }

    public function espace()
    {
        return view('pedagogique.espace');
    }

    public function inscriptions()
    {
        $inscriptions = Inscription::with(['etudiant', 'formation'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pedagogique.inscriptions', compact('inscriptions'));
    }

    public function valider($id)
    {
        $inscription = Inscription::findOrFail($id);

        if (!$inscription->valide_admin) {
            return redirect()->back()->with('error', 'Impossible de valider sans validation administrative.');
        }

        if ($inscription->valide_pedagogique) {
            return redirect()->back()->with('info', 'Cette inscription est déjà validée pédagogiquement.');
        }

        $inscription->update([
            'valide_pedagogique' => true,
            'pedagogique_validator_id' => auth()->id(),
            'date_validation_pedagogique' => now(),
        ]);

        return redirect()->back()->with('success', 'Validation pédagogique effectuée avec succès.');
    }

    public function refuser($id)
    {
        $inscription = Inscription::findOrFail($id);
        $inscription->delete();

        return redirect()->back()->with('success', 'Inscription refusée et supprimée avec succès.');
    }
}
