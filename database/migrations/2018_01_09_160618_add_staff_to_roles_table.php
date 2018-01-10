<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStaffToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('roles')) {
          Schema::table('roles', function (Blueprint $table) {
            $table->boolean('staff')->default(false);
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
        if (Schema::hasTable('roles'))
          Schema::table('roles', function (Blueprint $table) {
              $table->dropColumn('staff');
          });
    }
}
