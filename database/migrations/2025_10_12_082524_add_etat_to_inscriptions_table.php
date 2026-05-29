<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('inscriptions', function (Blueprint $table) {
        $table->string('etat')->nullable()->after('valide_pedagogique'); // ou une autre colonne existante
    });
}

public function down()
{
    Schema::table('inscriptions', function (Blueprint $table) {
        $table->dropColumn('etat');
    });
}
};
