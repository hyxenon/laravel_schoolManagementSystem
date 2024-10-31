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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // Foreign key to Subject table
            $table->foreignId('room_id')->constrained()->onDelete('cascade'); // Foreign key to Room table
            $table->foreignId('employee_id')->constrained()->onDelete('cascade'); // Foreign key to Employee table (teacher)
            $table->string('day_of_week'); // Day of the week (e.g., "Monday")
            $table->time('start_time'); // Start time of the schedule
            $table->time('end_time'); // End time of the schedule
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
