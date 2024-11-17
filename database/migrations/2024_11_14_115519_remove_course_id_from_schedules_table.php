<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {

            $table->dropForeign(['course_id']);


            $table->dropColumn('course_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {

            $table->unsignedBigInteger('course_id')->nullable();


            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }
};
