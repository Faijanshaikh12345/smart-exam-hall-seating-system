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
        Schema::create('hall_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_hall_id')->constrained('exam_halls')->cascadeOnDelete();
            $table->string('seat_number');
            $table->unsignedInteger('row_number')->nullable();
            $table->unsignedInteger('column_number')->nullable();
            $table->string('status')->default('available');
            $table->unique(['exam_hall_id', 'seat_number']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hall_seats');
    }
};
