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
        if (Schema::hasTable('event_types')) {
            Schema::table('event_types', function (Blueprint $table) {
                $table->boolean('is_public')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('event_types')) {
            Schema::table('event_types', function (Blueprint $table) {
                $table->dropColumn('is_public');
            });
        }
    }
};
