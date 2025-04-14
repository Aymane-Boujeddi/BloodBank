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
        Schema::create('rdvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_center_id')->constrained()->onDelete('cascade');
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->date('reservation_date');
            $table->time('reservation_time')->nullable();
            $table->enum('status',['pending','confirmed','cancelled'])->default('pending'); // pending, confirmed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rdvs');
    }
};
