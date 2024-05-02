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
        Schema::table('user_subscription', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('user_subscription', 'next_plan_id')) {
                $table->unsignedBigInteger('next_plan_id')->nullable();
                $table->foreign('next_plan_id')->references('id')->on('plans');
            }
            if (!Schema::hasColumn('user_subscription', 'subscription_id')) {
                $table->string('subscription_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_subscription', function (Blueprint $table) {
            //
            if (Schema::hasColumn('user_subscription', 'next_plan_id')) {
                $table->dropForeign(['next_plan_id']);
                $table->dropColumn('next_plan_id');
            }
            if (Schema::hasColumn('user_subscription', 'subscription_id')) {
                $table->dropColumn('subscription_id');
            }
        });
    }
};
