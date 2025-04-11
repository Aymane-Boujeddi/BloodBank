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
        Schema::create('donation_centers', function (Blueprint $table) {
            $table->id();
            $table->string('center_name');
            $table->string('address');
            $table->string('phone_number');
            $table->foreignId('user_id')->references('users')->on('id')->onDelete('cascade');
            $table->foreignId('city_id')->references('id')->on('cities')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_centers');
    }
};
