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
        Schema::table('permissionaccess', function (Blueprint $table) {
            //
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissionaccess', function (Blueprint $table) {
            //
            $table->dropForeign(['company_id']);
            $table->dropForeign(['permission_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
