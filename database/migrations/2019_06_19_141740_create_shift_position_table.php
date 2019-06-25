<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_position', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shift_id')->unsigned();
            //$table->foreign('shift_id')->references('id')->on('users'); // disabled due to MSSQL bug
            $table->integer('position_id')->unsigned();
            //$table->foreign('position_id')->references('id')->on('positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shift_position');
    }
}
