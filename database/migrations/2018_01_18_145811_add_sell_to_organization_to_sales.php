<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSellToOrganizationToSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (Schema::hasTable('sales')) {
        Schema::table('sales', function (Blueprint $table) {
          $table->boolean('sell_to_organization')->default(true);
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      if (Schema::hasTable('sales'))
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('sell_to_organization');
      });
    }
}
