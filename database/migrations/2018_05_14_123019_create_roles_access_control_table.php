<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesAccessControlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_access_control', function (Blueprint $table) {
            $table->increments('id');
            $table->char('dashboard', 4)->nullable();
            $table->char('shows', 4)->nullable();
            $table->char('products', 4)->nullable();
            $table->char('calendar', 4)->nullable();
            $table->char('sales', 4)->nullable();
            $table->char('reports', 4)->nullable();
            $table->char('members', 4)->nullable();
            $table->char('users', 4)->nullable();
            $table->char('organizations', 4)->nullable();
            $table->char('bulletin', 4)->nullable();
            $table->char('settings', 4)->nullable();
            $table->boolean('admin')->nullable();
            $table->boolean('cashier')->nullable();
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_access_control');
    }
}
