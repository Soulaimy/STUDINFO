<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UtilisateurController extends Controller
{
    public function index()
    {
        $users = User::all(); // récupère tous les utilisateurs
        return view('admin.inscriptions.utilisateurs', compact('users'));
    }

}