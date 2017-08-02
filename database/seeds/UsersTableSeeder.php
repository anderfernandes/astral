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
          'firstname'  => 'Anderson',
          'lastname'   => 'Fernandes',
          'email'      => 'admin@admin.com',
          'password'   =>  bcrypt('admin'),
          'role'       => 'admin',
        ]);
    }
}
