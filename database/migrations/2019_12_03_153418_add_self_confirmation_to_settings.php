<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSelfConfirmationToSettings extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('settings', function (Blueprint $table) {
      $table->boolean('self_confirmation')->default(false);
      $table->smallInteger('self_confirmation_days')->default(7);
      $table->string('self_confirmation_time')->default('07:30 AM');
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
      $table->dropIfExists(['self_confirmation', 'self_confirmation_days', 'self_confirmation_time']);
    });
  }
}
