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
        Schema::table('users', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('users', 'mandate_id')) {
                $table->string('mandate_id')->after('gc_customer_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'mandate_status')) {
                $table->string('mandate_status')->after('mandate_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            if (Schema::hasColumn('users', 'mandate_id')) {
                $table->dropColumn('mandate_id');
            }
            if (Schema::hasColumn('users', 'mandate_status')) {
                $table->dropColumn('mandate_status');
            }
        });
    }
};
