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
        Schema::table('user_experiences', function (Blueprint $table) {
            //
            $table->Unique(['user_id', 'company_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_experiences', function (Blueprint $table) {
            //
            $table->dropForeign(['user_id']); 
            $table->dropUnique(['user_id', 'company_name']);
        });
    }
};
