<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('email');
            $table->string('course');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->date('course_date');
            $table->date('expiry_date')->nullable();
            $table->date('inspection_date')->nullable();
            $table->string('site')->nullable();
            $table->boolean('designated_fa_attendant')->default('false');
            $table->string('union')->nullable();
            $table->string('fa_level')->nullable();
            $table->string('full_part_hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainings');
    }
}
