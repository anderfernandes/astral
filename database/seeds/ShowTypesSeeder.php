<?php

use Illuminate\Database\Seeder;

class ShowTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // No Type
      DB::table('show_types')->insert([
        'name'          => "No Type",
        'description'   => "Shows that don't have a type",
        'active'        => true,
        'creator_id'    => 1,
        'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // Planetarium
      DB::table('show_types')->insert([
        'name'          => "Planetarium",
        'description'   => "Full Dome planetarium shows",
        'active'        => true,
        'creator_id'    => 1,
        'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // Laser Light
      DB::table('show_types')->insert([
        'name'          => "Laser Light",
        'description'   => "Laser Light",
        'active'        => true,
        'creator_id'    => 1,
        'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
      ]);
    }
}
