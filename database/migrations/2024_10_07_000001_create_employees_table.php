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
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to User table
            $table->unsignedBigInteger('department_id')->nullable(); // Add department_id without foreign key constraint
            $table->string('position'); // Position of the employee, e.g., "Professor"
            $table->string('category'); // Category: e.g., "Faculty" or "Staff"
            $table->decimal('salary', 10, 2); // Salary of the employee
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
