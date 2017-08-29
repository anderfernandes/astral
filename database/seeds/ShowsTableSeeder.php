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
          'cover'       => 'https://semantic-ui.com/images/wireframe/image.png',
        ]);

        // Laser Light example show seed
        DB::table('shows')->insert([
          'name'        => 'Space Laser',
          'type'        => 'Laser Light',
          'duration'    => 45,
          'description' => 'Write a description here.',
          'cover'       => 'https://semantic-ui.com/images/wireframe/image.png',
        ]);
    }
}
