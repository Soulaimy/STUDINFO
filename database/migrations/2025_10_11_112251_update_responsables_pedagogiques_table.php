<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ajoute le champ name
        Schema::table('responsables_pedagogiques', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });

        // Copie les données de nom + prenom dans name
        DB::table('responsables_pedagogiques')->select('id', 'nom', 'prenom')->get()->each(function ($rp) {
            DB::table('responsables_pedagogiques')
                ->where('id', $rp->id)
                ->update(['name' => trim($rp->nom . ' ' . $rp->prenom)]);
        });

        // Supprime les colonnes nom et prenom
        Schema::table('responsables_pedagogiques', function (Blueprint $table) {
            $table->dropColumn(['nom', 'prenom']);
        });

        // Rend le champ name obligatoire
        Schema::table('responsables_pedagogiques', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('responsables_pedagogiques', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
        });
    }
};