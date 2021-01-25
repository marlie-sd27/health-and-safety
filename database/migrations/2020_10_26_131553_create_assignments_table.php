<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('events_id');
            $table->foreign('events_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');
            $table->bigInteger('sites_id')->nullable();
            $table->foreign('sites_id')
                ->references('id')
                ->on('sites')
                ->onDelete('cascade');
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
