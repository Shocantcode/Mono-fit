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
        Schema::create('onboardings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('age');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->float('height'); // in cm
            $table->float('weight'); // in kg
            $table->float('body_fat')->nullable();
            $table->string('activity_level');
            $table->enum('fitness_goal', ['fat_loss', 'muscle_gain', 'maintenance']);
            $table->json('equipment');
            $table->float('bmi')->nullable();
            $table->float('bmr')->nullable();
            $table->float('tdee')->nullable();
            $table->string('somatotype')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboardings');
    }
};
