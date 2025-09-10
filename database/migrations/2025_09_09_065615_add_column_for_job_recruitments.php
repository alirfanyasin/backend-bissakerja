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
        Schema::table('recruitments', function (Blueprint $table) {
            $table->enum('status_candidate', array_column(\App\Enum\StatusCandidateRecruitment::cases(), 'value'))
                ->after('post_lowongan_id');
        });

        Schema::table('recruitments', function (Blueprint $table) {
            $table->enum('status_perusahaan', array_column(\App\Enum\StatusPerusahaanRecruitment::cases(), 'value'))
                ->after('status_candidate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recruitments', function (Blueprint $table) {
            $table->dropColumn('status_candidate');
        });

        Schema::table('recruitments', function (Blueprint $table) {
            $table->dropColumn('status_perusahaan');
        });
    }
};
