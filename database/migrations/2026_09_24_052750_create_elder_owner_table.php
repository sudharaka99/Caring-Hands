<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elder_owner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elder_id')->constrained('elders')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['elder_id', 'owner_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elder_owner');
    }
};