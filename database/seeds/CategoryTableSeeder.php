<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('categories')->insert([
          'name'        => 'bugs',
          'description' => 'All Astral bugs should be posted under this category.',
          'creator_id'  => 2,
          'created_at'  => Date::now('America/Chicago'),
        ]);
    }
}
