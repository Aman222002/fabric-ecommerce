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
            $table->text('favorite_coffee')->after('avatar');
            $table->text('flavor_notes')->after('favorite_coffee');
            $table->boolean('profile_visibility')->default('1')->after('flavor_notes');
            $table->string('city')->after('profile_visibility');
            $table->string('state')->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('favorite_coffee');
            $table->dropColumn('flavor_notes');
            $table->dropColumn('profile_visibility');
            $table->dropColumn('city');
            $table->dropColumn('state');
        });
    }
};
