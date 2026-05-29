<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValidationFieldsToInscriptionsTable extends Migration
{
    /**
     * Ajouter les colonnes valide_admin et valide_pedagogique.
     */
    public function up(): void
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->boolean('valide_admin')->default(false)->after('created_at');
            $table->boolean('valide_pedagogique')->default(false)->after('valide_admin');
        });
    }

    /**
     * Supprimer les colonnes si on rollback.
     */
    public function down(): void
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->dropColumn(['valide_admin', 'valide_pedagogique']);
        });
    }
}
