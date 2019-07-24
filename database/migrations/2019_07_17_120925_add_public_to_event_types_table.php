<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicToEventTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('event_types'))
        {
          Schema::table('event_types', function (Blueprint $table) {
            $table->boolean('public')->default(false);
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
      if (Schema::hasTable('event_types'))
      {
        Schema::table('event_types', function (Blueprint $table) {
          $table->dropIfExists('public');
        });
      }
    }
}
