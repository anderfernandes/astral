<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ShowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::createFromTimestampUTC(0)->toDateTimeString();
        
        // Planetarium example show seed
        DB::table('shows')->insert([
          'name'        => 'No Show',
          'type'        => 'system',
          'duration'    => 1,
          'description' => 'Write a description here.',
          'cover'       => '/default.png',
          'creator_id'  => 1,
          'active'      => false,
          'type_id'     => 1,
          'created_at'  => $date,
          'updated_at'  => $date,
        ]);
        
        // Planetarium example show seed
        DB::table('shows')->insert([
          'name'        => 'Black Holes: The Other Side of Infinity',
          'type'        => 'Planetarium',
          'duration'    => 25,
          'description' => 'Write a description here.',
          'cover'       => '/default.png',
          'creator_id'  => 2,
          'active'      => true,
          'type_id'     => 2,
          'created_at'  => $date,
        ]);

        // Laser Light example show seed
        DB::table('shows')->insert([
          'name'        => 'Laser Daft Punk',
          'type'        => 'Laser Light',
          'duration'    => 45,
          'description' => 'Write a description here.',
          'cover'       => '/default.png',
          'creator_id'  => 2,
          'active'      => true,
          'type_id'     => 2,
          'created_at'  => $date,
        ]);
    }
}
