<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // 1
      DB::table('roles')->insert([
        'name'        => 'walk-up',
        'description' => 'Walk-up account.',
        'type'        => 'walk-up',
        'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 2
      DB::table('roles')->insert([
        'name'        => 'Senior Staff',
        'description' => 'Senior Staff accounts.',
        'type'        => 'individuals',
        'staff'       => true,
        'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 3
      DB::table('roles')->insert([
        'name'        => 'Planetarium Lead Assistant',
        'description' => 'Planetarium Lead Assistant accounts.',
        'type'        => 'individuals',
        'staff'       => true,
        'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 4
      DB::table('roles')->insert([
        'name'        => 'Planetarium Assistant',
        'description' => 'Planetarium Assistant accounts.',
        'type'        => 'individuals',
        'staff'       => true,
        'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 5
      DB::table('roles')->insert([
        'name'        => 'Member',
        'description' => 'Member accounts',
        'type'        => 'members',
        'staff'       => false,
        'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 6
      DB::table('roles')->insert([
        'name'        => 'Community College',
        'description' => 'Community College accounts.',
        'type'        => 'organizations',
        'staff'       => false,
        'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 7
      DB::table('roles')->insert([
        'name'        => 'Visitor',
        'description' => 'Visitor accounts.',
        'type'        => 'individuals',
        'staff'       => false,
        'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 8
      DB::table('roles')->insert([
        'name'        => 'Teacher',
        'description' => 'Teacher accounts.',
        'type'        => 'individuals',
        'staff'       => false,
        'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
      ]);
    }
}
