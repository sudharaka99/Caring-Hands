<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elder_id')->constrained('elders')->onDelete('cascade');
            $table->enum('appointment_type', ['doctor', 'healthcare', 'hospital', 'clinic', 'therapy', 'checkup', 'other'])->default('doctor');
            $table->string('title');
            $table->string('doctor_name')->nullable();
            $table->string('hospital_name')->nullable();
            $table->string('location')->nullable();
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->integer('duration_minutes')->nullable();
            $table->text('reason')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled', 'rescheduled', 'missed'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};