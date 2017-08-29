<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('organization')->nullable();
            $table->integer('seats');
            $table->string('logo')->nullable()->default('logo.png');
            $table->string('cover')->nullable()->default('cover.jpg');
            $table->decimal('adults_weekend')->nullable();
            $table->decimal('adults_matinee')->nullable();
            $table->decimal('adults_special_event')->nullable();
            $table->decimal('children_weekend')->nullable();
            $table->decimal('children_matinee')->nullable();
            $table->decimal('children_special_event')->nullable();
            $table->decimal('members_weekend')->nullable();
            $table->decimal('members_matinee')->nullable();
            $table->decimal('members_special_event')->nullable();
            $table->float('tax')->nullable()->default(8.25);
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
        Schema::dropIfExists('settings');
    }
}
