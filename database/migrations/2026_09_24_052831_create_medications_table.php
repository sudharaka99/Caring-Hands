<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elder_id')->constrained('elders')->onDelete('cascade');
            $table->string('medication_name');
            $table->string('generic_name')->nullable();
            $table->string('dosage', 100);
            $table->string('dosage_unit', 50)->nullable();
            $table->enum('frequency', ['once_daily', 'twice_daily', 'three_times_daily', 'four_times_daily', 'as_needed', 'weekly', 'custom'])->default('once_daily');
            $table->time('administration_time')->nullable();
            $table->enum('route', ['oral', 'injection', 'topical', 'inhalation', 'eye', 'ear', 'other'])->default('oral');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('prescribed_by')->nullable();
            $table->text('purpose')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('status', ['active', 'completed', 'stopped', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};