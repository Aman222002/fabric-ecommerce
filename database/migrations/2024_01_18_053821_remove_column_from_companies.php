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
        Schema::table('companies', function (Blueprint $table) {
            //
            if (Schema::hasColumn('companies', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('companies', 'password')) {
                $table->dropColumn('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('companies', 'username')) {
                $table->string('username');
            }
            if (!Schema::hasColumn('companies', 'password')) {
                $table->string('password');
            }
        });
    }
};
