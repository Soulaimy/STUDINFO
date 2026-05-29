<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Etudiant\EtudiantController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FormationController as AdminFormationController;
use App\Http\Controllers\Admin\InscriptionController;
use App\Http\Controllers\Pedagogique\PedagogiqueController;
use App\Http\Controllers\Pedagogique\FormationController as PedagogiqueFormationController;
use App\Http\Controllers\Etudiant\PaiementController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Models\Formation;

// === Accueil
Route::get('/', function () {
    $formations = Formation::all();
    return view('welcome', compact('formations'));
})->name('home');

// === Routes après connexion et email vérifié
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $formations = Formation::all();
        return view('dashboard', compact('formations'));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
});

// === Étudiant
Route::middleware(['auth', 'role:etudiant'])
    ->prefix('etudiant')
    ->name('etudiant.')
    ->group(function () {

        Route::get('/espace', [EtudiantController::class, 'espace'])->name('espace');
        Route::get('/formations', [EtudiantController::class, 'formations'])->name('formations');

        // Profil étudiant
        Route::get('/profil', [\App\Http\Controllers\Etudiant\ProfileController::class, 'index'])
            ->name('profil');

        // Mise à jour du profil
        Route::put('/profil/update', [\App\Http\Controllers\Etudiant\ProfileController::class, 'update'])
            ->name('profile.update');
        // Afficher formulaire d'inscription (GET)
        Route::get('/inscription/{formationId}', [EtudiantController::class, 'afficherFormulaire'])->name('inscription.formulaire');

        // Soumettre formulaire d'inscription (POST)
        Route::post('/inscription/{formationId}', [EtudiantController::class, 'soumettreFormulaire'])->name('inscription.submit');

        // Inscrire l'étudiant à une formation (POST) — création de l'inscription
        Route::post('/inscrire/{formationId}', [EtudiantController::class, 'inscrire'])->name('inscription.creer');

        // Liste des inscriptions
        Route::get('/inscriptions', [EtudiantController::class, 'mesInscriptions'])->name('inscriptions');

        // Annulation d'une inscription
        Route::post('/inscription/{inscriptionId}/annuler', [EtudiantController::class, 'annulerInscription'])->name('inscription.annuler');
  
        // pour le payement
         Route::get('/paiement/{id}', [PaiementController::class, 'show'])->name('paiement.show');
           Route::post('/paiement/{id}/process', [PaiementController::class, 'process'])->name('paiement.process');

        Route::get('/admin/etudiant/{id}', [InscriptionController::class, 'show'])
    ->name('admin.etudiant.profil');
    });

// === Responsable pédagogique (validation uniquement)
Route::middleware(['auth', 'role:responsable pedagogique'])->prefix('pedagogique')->name('pedagogique.')->group(function () {
    Route::get('/espace', [PedagogiqueController::class, 'espace'])->name('espace');
    Route::get('/inscriptions', [PedagogiqueController::class, 'inscriptions'])->name('inscriptions');

    Route::post('/inscription/{id}/valider', [PedagogiqueController::class, 'valider'])->name('inscription.valider');
    Route::post('/inscription/{id}/refuser', [PedagogiqueController::class, 'refuser'])->name('inscription.refuser');

    // Liste formations avec nombre d'inscriptions
    Route::get('/formations', [PedagogiqueFormationController::class, 'index'])->name('formations.index');

    // Voir inscriptions d'une formation
    Route::get('/formations/{formation}/inscriptions', [PedagogiqueFormationController::class, 'inscriptions'])->name('formations.inscriptions');
    
});

// === Responsable administratif (validation + gestion)
Route::middleware(['auth', 'role:responsable administratif'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/utilisateurs', [AdminController::class, 'utilisateurs'])->name('utilisateurs');
    Route::get('/formations', [AdminFormationController::class, 'index'])->name('formations');
    Route::get('/formations/create', [AdminFormationController::class, 'create'])->name('formations.create');
    Route::post('/formations', [AdminFormationController::class, 'store'])->name('formations.store');
    Route::get('/inscriptions', [InscriptionController::class, 'index'])->name('inscriptions');
    Route::post('/inscription/{id}/valider-admin', [InscriptionController::class, 'validerAdmin'])->name('valider.admin');
    Route::post('/inscriptions/{id}/refuser', [InscriptionController::class, 'refuserAdmin'])->name('refuser.admin');
    Route::delete('/inscriptions/{id}', [InscriptionController::class, 'destroy'])->name('inscriptions.destroy');
    Route::get('/export/utilisateurs', [AdminController::class, 'exportUtilisateurs'])->name('export.utilisateurs');
    Route::get('/export/statistiques', [AdminController::class, 'exportStatistiques'])->name('export.statistiques');

    // Voir profil étudiant
    Route::get('/etudiant/{id}', [AdminController::class, 'voirProfil'])->name('etudiant.profil');

    // Gestion formations
    Route::get('/formations/{formation}/edit', [AdminFormationController::class, 'edit'])->name('formations.edit');
    Route::put('/formations/{formation}', [AdminFormationController::class, 'update'])->name('formations.update');
    Route::delete('/formations/{formation}', [AdminFormationController::class, 'destroy'])->name('formations.destroy');
});

// === Page attente validation
Route::get('/attente-validation', function () {
    return view('attente_validation');
})->middleware(['auth'])->name('attente.validation');

// === Auth routes
require __DIR__.'/auth.php';