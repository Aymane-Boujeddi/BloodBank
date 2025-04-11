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
        Schema::create('donation_center_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_center_id')->constrained()->onDelete('cascade');
            $table->enum('day_of_week',['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']); 
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamps();

            $table->unique(['donation_center_id', 'day_of_week']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_center_hours');
    }
};
