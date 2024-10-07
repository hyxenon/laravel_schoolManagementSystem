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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Title of the assignment
            $table->text('description')->nullable(); // Description of the assignment (optional)
            $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // Foreign key to Subject table
            $table->foreignId('employee_id')->constrained()->onDelete('cascade'); // Foreign key to Employee table (teacher who created it)
            $table->date('due_date'); // Due date of the assignment
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
