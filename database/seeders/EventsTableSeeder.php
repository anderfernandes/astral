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
    public function run()
    {
        $date = Carbon::createFromTimestampUTC(0)->toDateTimeString();
        
        DB::table('events')->insert([
          'start'      => $date,
          'end'        => $date,
          'type_id'    => 1,
          'show_id'    => 1,
          'seats'      => 0,
          'creator_id' => 1,
          'created_at' => now(config('app.timezone')),
        ]);
    }
}
