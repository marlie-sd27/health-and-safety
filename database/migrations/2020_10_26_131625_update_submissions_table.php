<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->bigInteger('sites_id')->nullable();
            $table->foreign('sites_id')
                ->references('id')
                ->on('sites')
                ->onDelete('set null');
            $table->bigInteger('assignments_id')->nullable();
            $table->foreign('assignments_id')
                ->references('id')
                ->on('assignments')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn( ['sites_id', 'assignments_id']);
            $table->string('site');
        });
    }
}
