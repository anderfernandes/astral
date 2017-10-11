<?php

use Illuminate\Database\Seeder;

class ShowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Planetarium example show seed
      DB::table('shows')->insert([
        'name'        => 'No Show',
        'type'        => 'system',
        'duration'    => 1,
        'description' => 'Write a description here.',
        'cover'       => 'https://semantic-ui.com/images/wireframe/image.png',
        'creator_id'  => 1,
        'created_at'  => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
      ]);
      // Planetarium example show seed
      DB::table('shows')->insert([
        'name'        => 'Black Holes: The Other Side of Infinity',
        'type'        => 'Planetarium',
        'duration'    => 25,
        'description' => 'Write a description here.',
        'cover'       => 'http://www.starsatnight.org/sciencetheater/assets/File/200x300_blackholes.png',
        'creator_id'  => 2,
        'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
      ]);

      // Laser Light example show seed
      DB::table('shows')->insert([
        'name'        => 'Laser Daft Punk',
        'type'        => 'Laser Light',
        'duration'    => 45,
        'description' => 'Write a description here.',
        'cover'       => 'http://www.starsatnight.org/sciencetheater/assets/File/200x300_daftpunk.png',
        'creator_id'  => 2,
        'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
      ]);
    }
}
