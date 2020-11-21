<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentGatewayFieldToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('gateway', 16)->nullable();
            $table->string('gateway_merchant_id')->nullable();
            $table->string('gateway_public_key', 32)->nullable();
            $table->string('gateway_private_key', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
              'gateway',
              'gateway_merchant_id',
              'gateway_public_key', 
              'gateway_private_key'
            ]);
        });
    }
}
