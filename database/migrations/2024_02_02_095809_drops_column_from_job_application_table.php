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
        Schema::table('job_application', function (Blueprint $table) {
            //
            // $table->dropConstrainedForeignId('job_id');
            // $table->dropForeign(['job_id']);
           
            // $table->dropColumn('job_id');
            $table->unsignedBigInteger('job_id')->nullable()->after('id');
            $table->foreign('job_id')->references('id')->on('post_jobs')->onDelete('set NULL');
            //$table->foreignId('job_id')->constrained('post_jobs')->onDelete('set NULL');
        });
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_application', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropColumn('job_id');
           // $table->foreignId('job_id')->constrained('post_jobs')->onDelete('cascade');
        });
    }
};
