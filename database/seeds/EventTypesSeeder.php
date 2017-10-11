<?php

use Illuminate\Database\Seeder;

class EventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // System Type Event
      DB::table('event_types')->insert([
        'name' => 'system',
        'description' => 'system',
        'created_at' => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
      ]);

      DB::table('event_types')->insert([
        'name' => 'Matinee',
        'description' => 'Weekday shows with a single price for all ages',
        'created_at' => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      DB::table('event_types')->insert([
        'name' => 'Weekend',
        'description' => 'Weekend shows',
        'created_at' => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      DB::table('event_types')->insert([
        'name' => 'Special Event',
        'description' => 'Special Event',
        'created_at' => Date::now('America/Chicago')->toDateTimeString(),
      ]);
    }
}
