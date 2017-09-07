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
        'name'        => 'Black Holes: The Other Side of Infinity',
        'type'        => 'Planetarium',
        'duration'    => 25,
        'description' => 'Write a description here.',
        'cover'       => 'http://www.starsatnight.org/sciencetheater/assets/File/200x300_blackholes.png',
        'creator_id'  => 2,
      ]);

      // Laser Light example show seed
      DB::table('shows')->insert([
        'name'        => 'Laser Daft Punk',
        'type'        => 'Laser Light',
        'duration'    => 45,
        'description' => 'Write a description here.',
        'cover'       => 'http://www.starsatnight.org/sciencetheater/assets/File/200x300_daftpunk.png',
        'creator_id'  => 2,
      ]);
    }
}
