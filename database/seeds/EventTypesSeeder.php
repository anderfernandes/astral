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
        'creator_id' => 1,
        'created_at' => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
      ]);

      DB::table('event_types')->insert([
        'name' => 'Matinee',
        'description' => 'Weekday shows with a single price for all ages',
        'creator_id' => 1,
        'created_at' => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      DB::table('event_types')->insert([
        'name' => 'Weekend',
        'description' => 'Weekend shows',
        'creator_id' => 1,
        'created_at' => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      DB::table('event_types')->insert([
        'name' => 'Special Event',
        'description' => 'Special Event',
        'creator_id' => 1,
        'created_at' => Date::now('America/Chicago')->toDateTimeString(),
      ]);
    }
}
