<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('elder_code', 50)->nullable()->unique();
            $table->string('nic', 50)->nullable();
            $table->date('dob')->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('blood_group', 5)->nullable();
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            $table->string('emergency_contact_relationship', 100)->nullable();
            $table->string('room', 50);
            $table->string('caregiver')->nullable();
            $table->date('admission_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('medical_notes')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elders');
    }
};