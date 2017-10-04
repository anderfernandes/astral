<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users');
            $table->enum('status', ['open', 'tentative', 'no show', 'complete', 'canceled']);
            $table->boolean('taxable');
            $table->decimal('subtotal', 4, 2)->nullable();
            $table->decimal('tax', 4, 2)->nullable();
            $table->decimal('total', 4, 2)->nullable();
            $table->boolean('refund');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->integer('first_event_id');
            $table->foreign('first_event_id')->references('id')->on('events');
            $table->integer('second_event_id');
            $table->foreign('second_event_id')->references('id')->on('events');
            $table->text('memo')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
