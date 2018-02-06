<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_memos', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('users');
            $table->integer('sale_id')->unsigned();
            $table->foreign('sale_id')->references('id')->on('sales');
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
        Schema::dropIfExists('sale_memos');
    }
}
