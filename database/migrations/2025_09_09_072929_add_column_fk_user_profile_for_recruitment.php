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
        // Drop user fk
        Schema::table('recruitments', function (Blueprint $table) {
            $table->dropForeign('recruitments_user_id_foreign');
            $table->dropColumn('user_id');
        });

        // Create user profile fk
        Schema::table('recruitments', function (Blueprint $table) {
            $table->foreignId('user_profile_id')->constrained('user_profiles')->cascadeOnDelete()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop user_profile fk & column
        Schema::table('recruitments', function (Blueprint $table) {
            $table->dropForeign(['user_profile_id']);
            $table->dropColumn('user_profile_id');
        });

        // Re-create user_id fk
        Schema::table('recruitments', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->after('id');
        });
    }
};
