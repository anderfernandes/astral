<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
          'name' => 'Star Talk',
          'description' => 'Classic planetarium presentation about the night sky.',
          'creator_id'  => 1,
          'type_id'     => 1,
          'cover'       => '/default.png',
          'price'       => number_format(0, 2),
          'created_at'  => Date::now()->toDateTimeString(),
        ]);
        DB::table('products')->insert([
          'name' => 'Uniview',
          'description' => 'Full dome live flight around the universe using Uniview',
          'creator_id'  => 1,
          'type_id'     => 1,
          'cover'       => '/default.png',
          'price'       => number_format(0, 2),
          'created_at'  => Date::now()->toDateTimeString(),
        ]);
    }
}
