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
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('self_confirmation')->default(false);
            $table->smallInteger('self_confirmation_days')->default(7);
            $table->string('self_confirmation_time')->default('07:30 AM');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['self_confirmation', 'self_confirmation_days', 'self_confirmation_time']);
        });
    }
};
