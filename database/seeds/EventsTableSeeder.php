<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
          'start'      => Date::createFromDate(1970, 1, 1, 'America/Chicago')->toDateTimeString(),
          'end'        => Date::createFromDate(1970, 1, 1, 'America/Chicago')->toDateTimeString(),
          'type'       => 'system',
          'show_id'    => 1,
          'seats'      => 0,
          'creator_id' => 1,
          'created_at' => Date::createFromDate(1970, 1, 1, 'America/Chicago')->toDateTimeString(),
        ]);
    }
}
