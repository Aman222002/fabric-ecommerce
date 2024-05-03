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
        if (!Schema::hasTable('features')) {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('Search');
            $table->string('Mails');
            $table->string('Price');
            $table->string('Validity');
            $table->string('Post Job');
            $table->string('Duration of Job-Post');
            $table->string('Number of Job-Post');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
