<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValidationPedagogiqueColumnsToInscriptionsTable extends Migration
{
    public function up()
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('inscriptions', 'valide_pedagogique')) {
                $table->boolean('valide_pedagogique')->default(false)->after('valide_admin');
            }
            if (!Schema::hasColumn('inscriptions', 'pedagogique_validator_id')) {
                $table->unsignedBigInteger('pedagogique_validator_id')->nullable()->after('valide_pedagogique');
                $table->foreign('pedagogique_validator_id')->references('id')->on('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('inscriptions', 'date_validation_pedagogique')) {
                $table->timestamp('date_validation_pedagogique')->nullable()->after('pedagogique_validator_id');
            }
        });
    }

    public function down()
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            if (Schema::hasColumn('inscriptions', 'date_validation_pedagogique')) {
                $table->dropColumn('date_validation_pedagogique');
            }
            if (Schema::hasColumn('inscriptions', 'pedagogique_validator_id')) {
                $table->dropForeign(['pedagogique_validator_id']);
                $table->dropColumn('pedagogique_validator_id');
            }
            if (Schema::hasColumn('inscriptions', 'valide_pedagogique')) {
                $table->dropColumn('valide_pedagogique');
            }
        });
    }
}
