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
            $table->integer('cashier_id')->unsigned();
            $table->foreign('cashier_id')->references('id')->on('users');
            $table->string('payment_method');
            $table->decimal('tendered', 4, 2);
            $table->decimal('change_due', 4, 2);
            $table->string('reference')->nullable();
            $table->decimal('subtotal', 4, 2);
            $table->decimal('total', 4, 2);
            $table->string('source');
            $table->text('memo')->nullable();
            $table->boolean('refund');
            $table->integer('customer_id')->references('id')->on('users');
            $table->enum('status', ['open', 'tentative', 'no show', 'complete', 'canceled']);
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
