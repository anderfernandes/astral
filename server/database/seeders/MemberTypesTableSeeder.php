<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1
        DB::table('member_types')->insert([
            'name' => 'No Membership',
            'description' => 'No membership',
            'price' => 0,
            'duration' => 0,
            'max_secondaries' => 0,
            'secondary_price' => 0,
            'created_at' => now(),
        ]);
        // 2
        DB::table('member_types')->insert([
            'name' => 'Individual Membership',
            'description' => 'Individual Membership',
            'price' => 50,
            'duration' => 365,
            'max_secondaries' => 0,
            'secondary_price' => 25,
            'created_at' => now(),
        ]);
        // 3
        DB::table('member_types')->insert([
            'name' => 'Family Membership',
            'description' => 'Family Membership',
            'price' => 100,
            'duration' => 365,
            'max_secondaries' => 2,
            'secondary_price' => 25,
            'created_at' => now(),
        ]);
        // 4
        DB::table('member_types')->insert([
            'name' => 'Sponsor Membership',
            'description' => 'Sponsor Membership',
            'price' => 135,
            'duration' => 365,
            'max_secondaries' => 4,
            'secondary_price' => 25,
            'created_at' => now(),
        ]);
    }
}
