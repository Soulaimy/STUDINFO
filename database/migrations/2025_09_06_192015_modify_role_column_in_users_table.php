<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        // Changeons le type de la colonne 'role'
        DB::statement("ALTER TABLE users MODIFY role ENUM('etudiant', 'responsable administratif', 'responsable pedagogique')");
    }

    public function down(): void {
        // On revient à l'ancien ENUM si besoin
        DB::statement("ALTER TABLE users MODIFY role ENUM('etudiant', 'admin', responsable administratif','responsable pedagogique','pedagogique')");
    }
};