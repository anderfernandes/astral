<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatorFieldToSeveralTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_types', function (Blueprint $table) {
          $table->integer('creator_id')->unsigned()->default(1);
          $table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::table('member_types', function (Blueprint $table) {
          $table->integer('creator_id')->unsigned()->default(1);
          //$table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::table('members', function (Blueprint $table) {
          $table->integer('creator_id')->unsigned()->default(1);
          //$table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::table('organization_types', function (Blueprint $table) {
          $table->integer('creator_id')->unsigned()->default(1);
          //$table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::table('organizations', function (Blueprint $table) {
          $table->integer('creator_id')->unsigned()->default(1);
          //$table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::table('payment_methods', function (Blueprint $table) {
          $table->integer('creator_id')->unsigned()->default(1);
          $table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::table('roles', function (Blueprint $table) {
          $table->integer('creator_id')->unsigned()->default(1);
          //$table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::table('ticket_types', function (Blueprint $table) {
          $table->integer('creator_id')->unsigned()->default(1);
          $table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::table('users', function (Blueprint $table) {
          $table->integer('creator_id')->unsigned()->default(1);
          $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('event_types', function (Blueprint $table) {
        $table->dropColumn(['creator_id',]);
      });

      Schema::table('member_types', function (Blueprint $table) {
        $table->dropColumn(['creator_id',]);
      });

      Schema::table('members', function (Blueprint $table) {
        $table->dropColumn(['creator_id',]);
      });

      Schema::table('organization_types', function (Blueprint $table) {
        $table->dropColumn(['creator_id',]);
      });

      Schema::table('organizations', function (Blueprint $table) {
        $table->dropColumn(['creator_id',]);
      });

      Schema::table('payment_methods', function (Blueprint $table) {
        $table->dropColumn(['creator_id',]);
      });

      Schema::table('roles', function (Blueprint $table) {
        $table->dropColumn(['creator_id',]);
      });

      Schema::table('ticket_types', function (Blueprint $table) {
        $table->dropColumn(['creator_id',]);
      });

      Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['creator_id',]);
      });
    }
}
