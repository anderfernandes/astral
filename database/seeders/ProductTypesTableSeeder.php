<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
          'name'        => 'Post Shows',
          'description' => 'Free presentation included in each show',
          'creator_id'  => 1,
          'created_at'  => now(config('app.timezone'))->toDateTimeString(),
        ]);
    }
}
