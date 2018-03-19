<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Settings Table Seeder
      DB::table('settings')->insert([
        'organization' => 'Mayborn Science Theater',
        'seats'        => 180,
        'tax'          => 8.25,
        'created_at'   => Date::now('America/Chicago')->toDateTimeString(),
        'website'      => 'mynonprofit.org',
      ]);
    }
}
