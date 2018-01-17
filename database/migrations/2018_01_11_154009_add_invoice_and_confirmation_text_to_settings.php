<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceAndConfirmationTextToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('settings')) {
          Schema::table('settings', function (Blueprint $table) {
            $table->string('confirmation_text')->nullable();
            $table->string('invoice_text')->nullable();
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
        if (Schema::hasTable('settings'))
          Schema::table('settings', function (Blueprint $table) {
              $table->dropColumn('confirmation_text');
              $table->dropColumn('invoice_text');
        });
    }
}
