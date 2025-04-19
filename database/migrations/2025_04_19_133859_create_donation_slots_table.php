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
        Schema::create('donation_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_center_id')->constrained()->onDelete('cascade');
            $table->json('closed_days')->nullable(); 
            $table->json('unavailable_dates')->nullable(); 
            $table->integer('available_slots')->default(0); 
            $table->integer('reserved_slots')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_slots');
    }
};
