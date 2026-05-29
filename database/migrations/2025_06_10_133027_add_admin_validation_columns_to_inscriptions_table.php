<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminValidationColumnsToInscriptionsTable extends Migration
{
    public function up()
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('inscriptions', 'admin_validator_id')) {
                $table->unsignedBigInteger('admin_validator_id')->nullable()->after('valide_admin');
                $table->foreign('admin_validator_id')->references('id')->on('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('inscriptions', 'date_validation_admin')) {
                $table->timestamp('date_validation_admin')->nullable()->after('admin_validator_id');
            }
        });
    }

    public function down()
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->dropForeign(['admin_validator_id']);
            $table->dropColumn(['admin_validator_id', 'date_validation_admin']);
        });
    }
}

