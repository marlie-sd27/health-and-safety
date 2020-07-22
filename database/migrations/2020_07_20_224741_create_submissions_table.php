<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('events_id')->nullable();
            $table->foreign('events_id')->references('id')->on('events')->onDelete('cascade');
            $table->bigInteger('forms_id')->nullable();
            $table->foreign('forms_id')->references('id')->on('forms')->onDelete('cascade');
            $table->string('username');
            $table->string('email');
            $table->text('data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
}
