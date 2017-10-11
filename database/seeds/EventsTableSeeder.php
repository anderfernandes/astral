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
          'start'      => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
          'end'        => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
          'type_id'    => 1,
          'show_id'    => 1,
          'seats'      => 0,
          'creator_id' => 1,
          'created_at' => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
        ]);
    }
}
