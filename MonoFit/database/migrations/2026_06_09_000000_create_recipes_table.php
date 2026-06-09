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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('goal')->default('all');
            $table->string('description', 512)->nullable();
            $table->string('image_url')->nullable();
            $table->json('ingredients');
            $table->json('steps');
            $table->float('calories')->nullable();
            $table->float('protein')->nullable();
            $table->float('carbs')->nullable();
            $table->float('fat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
