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
        Schema::table('user_qualifications', function (Blueprint $table) {
            if (!Schema::hasIndex('user_qualifications', 'user_qualifications_user_id_education_type_unique')) {
                $table->unique(['user_id', 'education_type']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_qualifications', function (Blueprint $table) {
            if (Schema::hasIndex('user_qualifications', 'user_qualifications_user_id_education_type_unique')) {
                $table->dropUnique(['user_id', 'education_type']);
            }
        });
    }
};
