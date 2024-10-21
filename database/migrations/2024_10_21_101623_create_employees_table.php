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
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->enum('employment_type', ['full-time', 'part-time']);
            $table->decimal('base_salary', 10, 2);
            $table->decimal('hourly_rate', 10, 2)->nullable(); // For part-time employees
            $table->integer('paid_leave_days')->default(0); // Full-time leave
            $table->integer('unpaid_leave_days')->default(0); // All types of unpaid leave
            $table->timestamps();
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
