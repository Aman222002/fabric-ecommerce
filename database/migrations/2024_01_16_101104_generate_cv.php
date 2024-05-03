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
        if (!Schema::hasTable('generate_cv')) {
        Schema::create('generate_cv', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('hobbies');
            $table->string('highest_education');
            $table->string('university');
            $table->string('starting_year');
            $table->string('passing_year');
            $table->string('skills');
            $table->text('address');
            $table->string('upload_image')->nullable();
            $table->boolean('is_publish')->default(0);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generate_cv');
    }
};
