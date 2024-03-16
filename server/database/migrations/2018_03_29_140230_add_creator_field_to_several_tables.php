<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('event_types', function (Blueprint $table) {
            $table->integer('creator_id')->unsigned()->default(1);
            $table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::table('member_types', function (Blueprint $table) {
            $table->integer('creator_id')->unsigned()->default(1);
        });
        Schema::table('members', function (Blueprint $table) {
            $table->integer('creator_id')->unsigned()->default(1);
        });
        Schema::table('organization_types', function (Blueprint $table) {
            $table->integer('creator_id')->unsigned()->default(1);
        });
        Schema::table('organizations', function (Blueprint $table) {
            $table->integer('creator_id')->unsigned()->default(1);
        });
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->integer('creator_id')->unsigned()->default(1);
            $table->foreign('creator_id')->references('id')->on('users');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->integer('creator_id')->unsigned()->default(1);
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
     */
    public function down(): void
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
};
