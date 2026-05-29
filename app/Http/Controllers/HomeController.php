<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        return match ($role) {
            'admin' => redirect('/admin/dashboard'),
            'pedagogique' => redirect('/pedagogique/formations'),
            'etudiant' => redirect('/etudiant/statut'),
            default => abort(403)
        };
    }
}
