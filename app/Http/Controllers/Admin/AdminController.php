<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use App\Models\Formation;
use App\Models\Inscription;

class AdminController extends Controller
{
    // Tableau de bord
    public function dashboard()
    {
        return view('admin.dashboard', [
            'usersCount' => User::count(),
            'formationsCount' => Formation::count(),
            'pendingInscriptions' => Inscription::count(),
        ]);
    }

    //  Export CSV des utilisateurs
    public function exportUtilisateurs()
    {
        $users = User::all();

        // Création du CSV
        $csv = "ID,Nom,Email\n";
        foreach ($users as $user) {
            $csv .= "{$user->id},{$user->name},{$user->email}\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="utilisateurs.csv"',
        ]);
    }

    //  Export CSV des statistiques d'inscriptions
    public function exportStatistiques()
    {
        $inscriptions = Inscription::with(['etudiant', 'formation'])->get();

        // Création du CSV
        $csv = "ID,Utilisateur,Formation,Date\n";
        foreach ($inscriptions as $inscription) {
            $csv .= "{$inscription->id},{$inscription->etudiant->name},{$inscription->formation->titre},{$inscription->created_at->format('d/m/Y H:i')}\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="statistiques.csv"',
        ]);
    }

    //  Liste des utilisateurs
    public function utilisateurs()
    {
        $users = User::all();
        return view('admin.utilisateurs', compact('users'));
    }

    //  Liste des formations
    public function formations()
{
    $formations = Formation::paginate(10); //  paginate au lieu de all()
    return view('admin.formations', compact('formations'));
}


    //  Liste des inscriptions
    public function inscriptions()
    {
        $inscriptions = Inscription::with([
            'etudiant',
            'formation',
            'adminValidator',
            'pedagogiqueValidator'
        ])->get();

        return view('admin.inscriptions', compact('inscriptions'));
    }

    // Voir le profil complet d’un étudiant
    public function voirProfil($id)
    {
        $etudiant = User::with('inscriptions.formation')->findOrFail($id);
        return view('admin.etudiants.profil', compact('etudiant'));
    }
}