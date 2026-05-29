<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Formation;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::paginate(10); // 10 items par page, ajustable
        return view('admin.formations.index', compact('formations'));
    }

    public function create()
    {
        return view('admin.formations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'duree' => 'required|integer|min:1',
        ]);

        Formation::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'duree' => $request->duree,
        ]);

        return redirect()->route('admin.formations')->with('success', 'Formation ajoutée avec succès.');
    }

    public function edit(Formation $formation)
    {
        return view('admin.formations.edit', compact('formation'));
    }

    public function update(Request $request, Formation $formation)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'duree' => 'required|integer|min:1',
        ]);

        $formation->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'duree' => $request->duree,
        ]);

        return redirect()->route('admin.formations')->with('success', 'Formation modifiée avec succès.');
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();

        return redirect()->route('admin.formations')->with('success', 'Formation supprimée avec succès.');
    }
}