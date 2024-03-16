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
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('address')->default("Your address");
            $table->string('city')->default("Your city");
            $table->string('state')->default("Texas");
            $table->string('zip')->default('76549');
            $table->string('country')->default("United States");
            $table->string('phone')->default("(555) 555-5555");
            $table->string('fax')->default("(555) 555-5555")->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
