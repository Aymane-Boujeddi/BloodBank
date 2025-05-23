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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained()->onDelete('cascade');
            $table->foreignId('blood_type_id')->constrained('blood_types')->onDelete('cascade');

            $table->float('hemoglobin', 5, 2)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->float('pulse', 5, 2)->nullable();
            $table->integer('amount');
            $table->boolean('has_medical_issues')->default(false);
            $table->text('medical_notes')->nullable();
            $table->date('next_eligible_donation_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
