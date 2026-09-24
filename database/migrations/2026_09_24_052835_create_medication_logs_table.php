<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medication_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medication_id')->constrained('medications')->onDelete('cascade');
            $table->foreignId('elder_id')->constrained('elders')->onDelete('cascade');
            $table->foreignId('caregiver_id')->nullable()->constrained('caregiver')->onDelete('set null');
            $table->date('scheduled_date');
            $table->time('scheduled_time')->nullable();
            $table->dateTime('administered_at')->nullable();
            $table->enum('status', ['pending', 'given', 'missed', 'skipped', 'refused'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medication_logs');
    }
};