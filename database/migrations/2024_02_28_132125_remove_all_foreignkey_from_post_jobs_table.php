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
            $table->dropForeign(['skill_id', 'user_id', 'category_id', 'job_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_jobs', function (Blueprint $table) {
            //
        });
    }
};
