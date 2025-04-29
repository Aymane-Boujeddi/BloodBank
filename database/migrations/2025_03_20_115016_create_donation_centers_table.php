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
            $table->double('latitude');
            $table->double('longitude');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->integer('hourly_rate')->default(0);
            $table->enum('status', ['pending', 'approved','rejected'])->default('pending');
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
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
