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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Foreign key to Student table
            $table->decimal('amount', 10, 2); // Amount paid
            $table->date('payment_date'); // Date of the payment
            $table->string('payment_type'); // Type of payment (e.g., "tuition", "library fee")
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
        Schema::dropIfExists('payments');
    }
};
