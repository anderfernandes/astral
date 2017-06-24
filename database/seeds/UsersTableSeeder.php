<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          'firstname'  => 'Admin',
          'lastname'   => 'Astral',
          'email'      => 'admin@starsatnight.org',
          'password'   =>  bcrypt('admin'),
          'role'       => 'admin',
        ]);
    }
}
