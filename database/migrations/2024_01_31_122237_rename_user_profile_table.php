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

                Schema::rename('user_profile', 'user_profiles');

                //

        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {

                Schema::rename('user_profiles', 'user_profile');

                //

        }
};