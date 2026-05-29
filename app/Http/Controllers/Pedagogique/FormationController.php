<?php

namespace App\Http\Controllers\Pedagogique;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Formation;

class FormationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:responsable pedagogique']);
    }

    public function index()
    {
        // Récupère les formations avec le nombre d'inscriptions
        $formations = Formation::withCount('inscriptions')->paginate(10);
        return view('pedagogique.formations.index', compact('formations'));
    }

    public function create()
    {
        return view('pedagogique.formations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
        ]);

        Formation::create($request->all());

        return redirect()->route('pedagogique.formations.index')->with('success', 'Formation ajoutée avec succès.');
    }

    public function edit(Formation $formation)
    {
        return view('pedagogique.formations.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
        ]);

        $formation->update($request->all());

        return redirect()->route('pedagogique.formations.index')->with('success', 'Formation mise à jour.');
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();

        return redirect()->route('pedagogique.formations.index')->with('success', 'Formation supprimée.');
    }

    // Nouvelle méthode pour afficher les inscriptions d'une formation
    public function inscriptions(Formation $formation)
    {
        $inscriptions = $formation->inscriptions()->with('etudiant')->get();
        return view('pedagogique.formations.inscriptions', compact('formation', 'inscriptions'));
    }
}