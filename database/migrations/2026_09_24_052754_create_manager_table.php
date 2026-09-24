<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manager', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('staff_code', 50)->nullable()->unique();
            $table->string('nic', 50)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('profile_photo')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('employment_type', 50)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_relationship', 100)->nullable();
            $table->string('emergency_phone', 20)->nullable();
            $table->text('qualifications')->nullable();
            $table->text('experience')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manager');
    }
};