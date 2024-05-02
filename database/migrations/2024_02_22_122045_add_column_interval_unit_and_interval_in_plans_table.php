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
        Schema::table('plans', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('plans', 'interval_unit')) {
                $table->string('interval_unit')->after('price')->nullable();
            }
            if (!Schema::hasColumn('plans', 'interval')) {
                $table->float('interval', 2, 1)->after('interval_unit')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            //
            if (Schema::hasColumn('plans', 'interval_unit')) {
                $table->dropColumn('interval_unit');
            }
            if (Schema::hasColumn('plans', 'interval')) {
                $table->dropColumn('interval');
            }
        });
    }
};
