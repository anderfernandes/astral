<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users');
            $table->enum('status', ['open', 'confirmed', 'tentative', 'no show', 'complete', 'canceled']);
            $table->enum('source', ['admin', 'cashier', 'online']);
            $table->boolean('taxable');
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->decimal('tax', 8, 2)->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->boolean('refund');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
