<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draws', function (Blueprint $table) {
            $table->increments('id');
            $table->date('draw_date');
            $table->string('day');
            $table->integer('wbOne');
            $table->integer('wbTwo');
            $table->integer('wbThree');
            $table->integer('wbFour');
            $table->integer('wbFive');
            $table->integer('powerball');
            $table->integer('powerplay');
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
        Schema::drop('draws');
    }
}
