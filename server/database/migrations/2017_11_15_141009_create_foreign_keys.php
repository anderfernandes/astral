<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite requires default values
        // Users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('role_id')->unsigned();
                $table->foreign('role_id')->references('id')->on('roles');
                $table->integer('organization_id')->unsigned()->default(1);
                $table->foreign('organization_id')->references('id')->on('organizations');
                $table->integer('membership_id')->unsigned()->default(1);
                $table->foreign('membership_id')->references('id')->on('members');
            });
        }
        // Events
        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                $table->integer('type_id')->unsigned();
                $table->foreign('type_id')->references('id')->on('event_types');
            });
        }
        // Sales
        if (Schema::hasTable('sales')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->integer('organization_id')->unsigned();
                $table->foreign('organization_id')->references('id')->on('organizations');
            });
        }
        // Tickets
        if (Schema::hasTable('tickets')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->integer('type_id')->unsigned();
                $table->foreign('type_id')->references('id')->on('ticket_types');
            });
        }
        // Organizations
        if (Schema::hasTable('organizations')) {
            Schema::table('organizations', function (Blueprint $table) {
                $table->integer('type_id')->unsigned()->default(1);
                $table->foreign('type_id')->references('id')->on('organization_types');
            });
        }
        // Organizations
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                $table->integer('type_id')->unsigned();
                $table->foreign('type_id')->references('id')->on('member_types');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['role_id', 'organization_id', 'membership_id']);
            });
        }
        // Events
        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('type_id');
            });
        }
        // Sales
        if (Schema::hasTable('sales')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('organization_id');
            });
        }
        // Tickets
        if (Schema::hasTable('tickets')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropColumn('type_id');
            });
        }
        // Organizations
        if (Schema::hasTable('organizations')) {
            Schema::table('organizations', function (Blueprint $table) {
                $table->dropColumn('type_id');
            });
        }
        // Organizations
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('type_id');
            });
        }
    }
};
