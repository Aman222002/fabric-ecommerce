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
        $connection = Schema::getConnection();
        $table = 'user_qualifications';
        $column = 'education_type';

        // Check if a unique constraint exists on the column
        $constraintExists = collect($connection->select("SHOW INDEX FROM $table WHERE Column_name = '$column' AND Non_unique = 0"))
            ->isNotEmpty();

        if ($constraintExists) {
            Schema::table($table, function (Blueprint $table) use ($column) {
                $table->dropUnique($column);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_qualifications', function (Blueprint $table) {
            $table->unique('education_type');
        });
    }
};
