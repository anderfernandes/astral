<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShowTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // No Type
        DB::table('show_types')->insert([
            'name' => "No Type",
            'description' => "Shows that don't have a type",
            'is_active' => true,
            'creator_id' => 1,
            'created_at' => now(),
        ]);
        // Planetarium
        DB::table('show_types')->insert([
            'name' => "Planetarium",
            'description' => "Full Dome planetarium shows",
            'is_active' => true,
            'creator_id' => 1,
            'created_at' => now(),
        ]);
        // Laser Light
        DB::table('show_types')->insert([
            'name' => "Laser Light",
            'description' => "Laser Light",
            'is_active' => true,
            'creator_id' => 1,
            'created_at' => now(),
        ]);
    }
}
