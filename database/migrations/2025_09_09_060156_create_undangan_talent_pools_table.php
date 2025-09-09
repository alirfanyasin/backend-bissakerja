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
        Schema::create('undangan_talent_pools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('perusahaan_profile_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['Menunggu Respon', 'Diterima', 'Ditolak', 'Dibatalkan', 'Wawancara', 'Dipekerjakan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undangan_talent_pools');
    }
};
