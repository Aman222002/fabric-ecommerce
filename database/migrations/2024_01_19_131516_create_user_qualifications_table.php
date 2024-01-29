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
        Schema::create('user_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('education_type');
            $table->string('school_unversity')->nullable(); // For High School or 10/12
            $table->unsignedSmallInteger('starting_year')->nullable(); // New column for starting year
            $table->unsignedSmallInteger('passing_year')->nullable(); // 
            $table->string('highest_education_path')->nullable();
            $table->tinyInteger('still_pursuing')->default(0); // New column for status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_qualifications');
    }
};