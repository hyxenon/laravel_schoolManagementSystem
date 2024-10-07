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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key to Student table (nullable for employee attendance)
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key to Employee table (nullable for student attendance)
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade'); // Foreign key to Schedule table
            $table->date('date'); // Date of attendance
            $table->string('status'); // Status of attendance (e.g., "present", "absent", "late")
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
