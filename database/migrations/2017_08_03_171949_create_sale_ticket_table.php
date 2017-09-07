<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_ticket', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned()->nullable();
            $table->foreign('sale_id')->references('id')->on('sales');
            // This will ensure that if a sale is deleted, all tickets associated with it will also be deleted
            $table->integer('ticket_id')->unsigned()->nullable();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_ticket');
    }
}
