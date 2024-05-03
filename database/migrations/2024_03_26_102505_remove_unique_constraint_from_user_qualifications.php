<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_qualifications', function (Blueprint $table) {
            //
            $table->dropUnique(['education_type']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_qualifications', function (Blueprint $table) {
            // Check if the unique constraint already exists before adding it
            $constraintExists = DB::select("SELECT COUNT(*) AS constraint_exists
                                             FROM information_schema.table_constraints
                                            WHERE table_name = 'user_qualifications'
                                              AND constraint_type = 'UNIQUE'
                                              AND constraint_name = 'user_qualifications_education_type_unique'");

            if (!$constraintExists[0]->constraint_exists) {
                $table->unique('education_type', 'user_qualifications_education_type_unique');
            }
        });
    }
};
