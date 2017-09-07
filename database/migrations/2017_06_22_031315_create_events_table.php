<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('start');
            $table->datetime('end');
            $table->string('type');
            $table->text('memo')->nullable();
            $table->integer('show_id')->unsigned();
            $table->foreign('show_id')->references('id')->on('shows');
            $table->decimal('adults_price')->nullable();
            $table->decimal('children_price')->nullable();
            $table->decimal('members_price')->nullable();
            $table->integer('seats');
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users');
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
        Schema::dropIfExists('events');
    }
}
