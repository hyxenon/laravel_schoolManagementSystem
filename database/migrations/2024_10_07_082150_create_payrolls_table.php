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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('employee_id')->constrained()->onDelete('cascade'); // Foreign key to Employee table
            $table->decimal('amount', 10, 2); // Amount of payment
            $table->date('payment_date'); // Date of the payment
            $table->string('status'); // Payment status (e.g., "paid", "pending")
            $table->text('remarks')->nullable(); // Additional remarks (optional)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
