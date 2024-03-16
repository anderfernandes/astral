<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // System Type Event
        DB::table('event_types')->insert([
            'name' => 'system',
            'description' => 'system',
            'creator_id' => 1,
            'color' => '#767676',
            'is_public' => false,
            'created_at' => Carbon::createFromTimestampUTC(0),
        ]);

        DB::table('event_types')->insert([
            'name' => 'Matinee',
            'description' => 'Weekday shows with a single price for all ages',
            'creator_id' => 1,
            'color' => '#21ba45',
            'is_public' => true,
            'created_at' => now(),
        ]);

        DB::table('event_types')->insert([
            'name' => 'Weekend',
            'description' => 'Weekend shows',
            'creator_id' => 1,
            'color' => '#21ba45',
            'is_public' => true,
            'created_at' => now(),
        ]);

        DB::table('event_types')->insert([
            'name' => 'Special Event',
            'description' => 'Special Event',
            'creator_id' => 1,
            'color' => '#f2711c',
            'is_public' => false,
            'created_at' => now(),
        ]);

        DB::table('event_types')->insert([
            'name' => 'School Groups',
            'description' => 'School Groups',
            'creator_id' => 1,
            'color' => '#6435c9',
            'is_public' => false,
            'created_at' => now(),
        ]);
    }
}
