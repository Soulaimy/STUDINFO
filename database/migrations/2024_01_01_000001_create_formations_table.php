<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description'); 
            $table->integer('duree');

            $table->text('conditions_acces')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('formations');
    }
};
