<?php

use Illuminate\Database\Seeder;

class ProductsTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->insert([
          'name' => 'Post Shows',
          'description' => 'Free presentation included in each show',
          'creator_id'  => 1,
          'created_at'  => Date::now()->toDateTimeString(),
        ]);
    }
}
