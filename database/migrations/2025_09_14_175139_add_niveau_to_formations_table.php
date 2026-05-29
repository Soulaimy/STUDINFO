<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->string('niveau')->nullable(); // ou 'titre' si c’est le nom de ta formation
        });
    }

    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->dropColumn('niveau');
        });
    }
};