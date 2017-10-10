<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllowedTicketEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allowed_ticket_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_type_id')->unsigned();
            $table->foreign('ticket_type_id')->references('id')->on('ticket_types');
            $table->integer('event_type_id')->unsigned();
            $table->foreign('event_type_id')->references('id')->on('event_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allowed_ticket_events');
    }
}
