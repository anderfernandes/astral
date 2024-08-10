<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'name' => 'Star Talk',
            'description' => 'Classic planetarium presentation about the night sky.',
            'creator_id' => 1,
            'type_id' => 1,
            'cover' => 'default.png',
            'price' => 0,
            'inventory' => false,
            'stock' => 0,
            'is_active' => true,
            'created_at' => now(),
            'is_public' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Uniview',
            'description' => 'Full dome live flight around the universe using Uniview',
            'creator_id' => 1,
            'type_id' => 1,
            'cover' => 'default.png',
            'inventory' => false,
            'stock' => 0,
            'price' => 0,
            'is_active' => true,
            'created_at' => now(),
            'is_public' => false,
        ]);
        DB::table('products')->insert([
            'name' => 'Astronaut Ice Cream',
            'description' => 'They say it\'s delicious...',
            'creator_id' => 1,
            'type_id' => 2,
            'cover' => 'default.png',
            'inventory' => true,
            'stock' => 100,
            'price' => 2,
            'is_active' => true,
            'created_at' => now(),
            'is_public' => true,
        ]);
    }
}
