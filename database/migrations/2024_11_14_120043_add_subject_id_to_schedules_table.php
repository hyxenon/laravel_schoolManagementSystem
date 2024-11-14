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

            $table->unsignedBigInteger('subject_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {

            $table->dropColumn('subject_id');
        });
    }
};
