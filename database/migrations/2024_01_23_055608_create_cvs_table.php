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
<<<<<<< HEAD:database/migrations/2024_01_19_062056_create_roles_table.php
        if (!schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }
=======
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->timestamps();
        });
>>>>>>> c31050688b381a531574f7d7dfa8cd492933ed5d:database/migrations/2024_01_23_055608_create_cvs_table.php
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
