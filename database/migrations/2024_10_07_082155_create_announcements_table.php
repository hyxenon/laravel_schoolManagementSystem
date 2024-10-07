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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Title of the announcement
            $table->text('content'); // Content of the announcement
            $table->string('target_audience'); // Target audience (e.g., "students", "faculty", "all")
            $table->timestamp('published_at')->nullable(); // Date and time when the announcement was published
            $table->foreignId('created_by')->constrained('employees')->onDelete('cascade'); // Foreign key to Employee table
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
