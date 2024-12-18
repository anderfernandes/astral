<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            "name"        => "Console",
            "description" => "Runs shows and controls the planetarium console.",
            "creator_id"  => 1,
            "created_at"  => now(),
            "updated_at"  => now(),
        ]);

        DB::table('positions')->insert([
            "name"        => "Float",
            "description" => "Oversees shift, making sure that everything goes fine.",
            "creator_id"  => 1,
            "created_at"  => now(),
            "updated_at"  => now(),
        ]);

        DB::table('positions')->insert([
            "name"        => "Cashier",
            "description" => "Runs the cash register.",
            "creator_id"  => 1,
            "created_at"  => now(),
            "updated_at"  => now(),
        ]);
    }
}
