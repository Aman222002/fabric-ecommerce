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
        Schema::table('job_types', function (Blueprint $table) {
            //
            if (Schema::hasColumn('job_types', 'status')) {
                $table->tinyInteger('status')->default(1)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_types', function (Blueprint $table) {
            //
            if (Schema::hasColumn('job_types', 'status')) {
                $table->integer('status')->default(1)->change();
            }
        });
    }
};
