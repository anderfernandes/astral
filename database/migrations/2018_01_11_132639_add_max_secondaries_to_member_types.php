<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaxSecondariesToMemberTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (Schema::hasTable('member_types')) {
        Schema::table('member_types', function (Blueprint $table) {
          $table->smallInteger('max_secondaries')->default(1);
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
        if (Schema::hasTable('member_types'))
          Schema::table('member_types', function (Blueprint $table) {
              $table->dropColumn('max_secondaries');
          });
    }
}
