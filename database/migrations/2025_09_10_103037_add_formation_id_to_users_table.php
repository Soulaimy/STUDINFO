
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajouter la colonne formation_id à la table users
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('formation_id')->nullable()->after('email');

            // (optionnel) ajouter la clé étrangère si la table 'formations' existe
            $table->foreign('formation_id')->references('id')->on('formations')->onDelete('set null');
        });
    }

    /**
     * Supprimer la colonne formation_id si on rollback
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['formation_id']);
            $table->dropColumn('formation_id');
        });
    }
};
