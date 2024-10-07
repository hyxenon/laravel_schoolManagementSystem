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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade'); // Foreign key to Assignment table
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Foreign key to Student table
            $table->timestamp('submitted_at'); // Date and time of the submission
            $table->string('file_path'); // File path of the submitted file
            $table->decimal('grade', 5, 2)->nullable(); // Grade received for the submission (optional)
            $table->text('remarks')->nullable(); // Additional remarks (optional)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
