<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cashier_id')->unsigned();
            $table->foreign('cashier_id')->references('id')->on('users');
            $table->integer('method_id')->unsigned();
            $table->foreign('method_id')->references('id')->on('payment_methods');
            $table->decimal('total', 8, 2)->nullable();
            $table->decimal('tendered', 8, 2)->nullable();
            $table->decimal('change_due', 8, 2)->nullable();
            $table->string('reference')->nullable();
            $table->enum('source', ['admin', 'cashier', 'online']);
            $table->integer('sale_id')->unsigned();
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
