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
        Schema::table('responsables_administratifs', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
        });

        // Copie nom + prenom dans name
        DB::table('responsables_administratifs')->select('id', 'nom', 'prenom')->get()->each(function ($ra) {
            DB::table('responsables_administratifs')
                ->where('id', $ra->id)
                ->update(['name' => trim($ra->nom . ' ' . $ra->prenom)]);
        });

        // Supprime les colonnes nom et prenom
        Schema::table('responsables_administratifs', function (Blueprint $table) {
            $table->dropColumn(['nom', 'prenom']);
        });

        // Rend name obligatoire
        Schema::table('responsables_administratifs', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('responsables_administratifs', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
        });
    }
};
