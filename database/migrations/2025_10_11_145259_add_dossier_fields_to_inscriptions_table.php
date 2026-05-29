<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  
    public function up(): void
{
    Schema::table('inscriptions', function (Blueprint $table) {
        $table->string('departement')->nullable();
        $table->string('ville')->nullable();
        $table->date('date_naissance')->nullable();
        $table->string('nom_diplome')->nullable();
        $table->decimal('moyenne', 4, 2)->nullable();
        $table->string('carte_identite')->nullable(); // chemin du fichier
        $table->string('diplome')->nullable();        // chemin du fichier
    });
}

public function down(): void
{
    Schema::table('inscriptions', function (Blueprint $table) {
        $table->dropColumn([
            'departement',
            'ville',
            'date_naissance',
            'nom_diplome',
            'moyenne',
            'carte_identite',
            'diplome',
        ]);
    });
}
};
