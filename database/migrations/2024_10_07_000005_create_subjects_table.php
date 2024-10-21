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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Name of the subject (e.g., "Biology 101")
            $table->string('code')->unique(); // Subject code (e.g., "BIO101")
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key to Course table, nullable for general subjects
            $table->integer('credits'); // Number of credits for the subject
            $table->text('description')->nullable(); // Description of the subject (optional)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
