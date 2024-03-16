<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('events')->insert([
            'start'      => Carbon::createFromTimestampUTC(0),
            'end'        => Carbon::createFromTimestampUTC(0),
            'type_id'    => 1,
            'show_id'    => 1,
            'seats'      => 0,
            'creator_id' => 1,
            'created_at' => now(),
        ]);
    }
}
