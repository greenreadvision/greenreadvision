<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVotesToInternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interns', function (Blueprint $table) {
            //
            $table->integer('intern_id')->primary()->autoIncrement();
            $table->string('name');
            $table->string('nickname');
            $table->string('email');
            $table->string('status');
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
        Schema::table('interns', function (Blueprint $table) {
            //
            Schema::drop('interns');
        });
    }
}
