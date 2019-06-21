<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMemberCardDimensionsToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedDecimal('membership_card_width', 8)->default(3.37);
            $table->unsignedDecimal('membership_card_height', 8)->default(2.125);
            $table->unsignedSmallInteger('membership_number_length', false)->default(3);
            $table->unsignedSmallInteger('cashier_customer_dropdown', false)->default(1);
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
            //
        });
    }
}
