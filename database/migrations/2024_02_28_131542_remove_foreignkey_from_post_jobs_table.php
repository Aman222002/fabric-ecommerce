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
        Schema::table('post_jobs', function (Blueprint $table) {
            //
            $table->dropForeign(['company_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_jobs', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('post_jobs', 'company_id')) {
                // Add the 'company_id' column
                $table->unsignedBigInteger('company_id')->nullable()->after('id');
                // Add the foreign key constraint
                $table->foreign('company_id')->references('id')->on('companies');
            }
        });
    }
};
