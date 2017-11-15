<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // SQLite requires default values
        // Users
        if (Schema::hasTable('users'))
        {
          Schema::table('users', function (Blueprint $table){
            $table->integer('role_id')->unsigned()->default(1);
            $table->foreign('role_id')->references('id')->on('roles');
            $table->integer('organization_id')->unsigned()->default(1);
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->integer('membership_id')->unsigned()->default(1);
            $table->foreign('membership_id')->references('id')->on('members');
          });
        }
        // Events
        if (Schema::hasTable('events'))
        {
          Schema::table('events', function (Blueprint $table){
            $table->integer('type_id')->unsigned()->default(1);
            $table->foreign('type_id')->references('id')->on('event_types');
          });
        }
        // Sales
        if (Schema::hasTable('sales'))
        {
          Schema::table('sales', function (Blueprint $table){
            $table->integer('organization_id')->unsigned()->default(1);
            $table->foreign('organization_id')->references('id')->on('organizations');
          });
        }
        // Tickets
        if (Schema::hasTable('tickets'))
        {
          Schema::table('tickets', function (Blueprint $table){
            $table->integer('ticket_type_id')->unsigned()->default(1);
            $table->foreign('ticket_type_id')->references('id')->on('ticket_types');
          });
        }
        // Organizations
        if (Schema::hasTable('organizations'))
        {
          Schema::table('organizations', function (Blueprint $table){
            $table->integer('type_id')->unsigned()->default(1);
            $table->foreign('type_id')->references('id')->on('organization_types');
          });
        }
        // Organizations
        if (Schema::hasTable('members'))
        {
          Schema::table('members', function (Blueprint $table){
            $table->integer('member_type_id')->unsigned()->default(1);
            $table->foreign('member_type_id')->references('id')->on('member_types');
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
        //
    }
}
