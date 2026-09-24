<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->enum('role', ['admin', 'manager', 'caregiver', 'healthcare']);
            $table->boolean('can_view')->default(1);
            $table->boolean('can_create')->default(0);
            $table->boolean('can_edit')->default(0);
            $table->boolean('can_delete')->default(0);
            $table->timestamps();
            $table->unique(['menu_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_access');
    }
};