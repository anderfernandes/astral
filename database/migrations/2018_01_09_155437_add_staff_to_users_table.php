<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStaffToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
          Schema::table('users', function (Blueprint $table) {
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
      if (Schema::hasTable('users'))
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('staff');
        });
    }
}
