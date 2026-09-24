<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('care_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elder_id')->constrained('elders')->onDelete('cascade');
            $table->foreignId('caregiver_id')->nullable()->constrained('caregiver')->onDelete('set null');
            $table->string('title');
            $table->text('care_needs')->nullable();
            $table->text('goals')->nullable();
            $table->text('activities')->nullable();
            $table->date('start_date');
            $table->date('review_date')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('care_plans');
    }
};