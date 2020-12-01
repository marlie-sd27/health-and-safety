<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('requirees')->nullable();
            $table->text('requirees_emails')->nullable();
            $table->text('requirees_sites')->nullable();
            $table->text('requirees_groups')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('requirees_emails')->nullable();
            $table->dropColumn('requirees_sites')->nullable();
            $table->dropColumn('requirees_groups')->nullable();
        });
    }
}
