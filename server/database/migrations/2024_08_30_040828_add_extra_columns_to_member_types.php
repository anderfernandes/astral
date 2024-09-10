<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('member_types', function (Blueprint $table) {
            $table->boolean('is_active')->default(false);
            $table->boolean('keep_remaining_days')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_types', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'keep_remaining_days']);
        });
    }
};
