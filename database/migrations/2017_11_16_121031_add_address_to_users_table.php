<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (Schema::hasTable('users'))
        Schema::table('users', function (Blueprint $table) {
          $table->string('address')->default("Your address");
          $table->string('city')->default("Your city");
          $table->string('state')->default("Texas");
          $table->string('zip')->default('76549');
          $table->string('country')->default("United States");
          $table->string('phone')->default("(555) 555-5555");
          $table->boolean('active')->default(false);
        });
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
            $table->dropColumn(['address', 'city', 'state', 'zip', 'country', 'phone']);
        });
    }
}
