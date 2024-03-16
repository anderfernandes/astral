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
        if (Schema::hasTable('member_types')) {
            Schema::table('member_types', function (Blueprint $table) {
                $table->smallInteger('max_secondaries')->default(1);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('member_types')) {
            Schema::table('member_types', function (Blueprint $table) {
                $table->dropColumn('max_secondaries');
            });
        }
    }
};
