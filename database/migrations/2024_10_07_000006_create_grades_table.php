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
        Schema::create('grades', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Foreign key to Student table
            $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // Foreign key to Subject table
            $table->decimal('grade_value', 5, 2); // Grade value (e.g., 85.50, 3.75)
            $table->string('term'); // Term for which the grade is given (e.g., "Prelim, Midterm", "Final")
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
