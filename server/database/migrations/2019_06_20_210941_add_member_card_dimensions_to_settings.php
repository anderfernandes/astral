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
            $table->decimal('membership_card_width', 8)->default(3.37);
            $table->decimal('membership_card_height', 8)->default(2.125);
            $table->unsignedSmallInteger('membership_number_length', false)->default(3);
            $table->unsignedSmallInteger('cashier_customer_dropdown', false)->default(1);
            $table->boolean("membership_card_barcode")->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('membership_card_width');
            $table->dropColumn('membership_card_height');
            $table->dropColumn('membership_number_length');
            $table->dropColumn('cashier_customer_dropdown');
            $table->dropColumn('membership_card_barcode');
        });
    }
};
