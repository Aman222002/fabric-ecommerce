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
        Schema::table('users', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('users', 'payment_id')) {
                $table->string('payment_id')->after('subscription_status')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            if (Schema::hasColumn('users', 'payment_id')) {
                $table->dropColumn('payment_id');
            }
        });
    }
};
