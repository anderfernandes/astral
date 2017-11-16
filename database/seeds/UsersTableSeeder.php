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
      // 1
      DB::table('users')->insert([
        'firstname'       => 'Walk-up',
        'lastname'        => '',
        'email'           => 'walkup@walkup.com',
        'password'        =>  bcrypt('Mayborn152'),
        'role_id'         => 1,
        'organization_id' => 1,
        'type'            => 'walk-up',
        'membership_id'   => 1,
        'address'         => '6200 W Central Texas Expwy',
        'city'            => 'Killeen',
        'state'           => 'Texas',
        'zip'             => '76549',
        'country'         => 'United States',
        'phone'           => '(254) 526-7161',
        'active'          => false,
        'created_at'      => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
      ]);
      // 2
      DB::table('users')->insert([
        'firstname'       => 'Anderson',
        'lastname'        => 'Fernandes',
        'email'           => 'anderson.fernandes@ctcd.edu',
        'password'        =>  bcrypt('admin'),
        'role_id'         => 2,
        'organization_id' => 2,
        'type'            => 'individual',
        'membership_id'   => 1,
        'address'         => '6200 W Central Texas Expwy',
        'city'            => 'Killeen',
        'state'           => 'Texas',
        'zip'             => '76549',
        'country'         => 'United States',
        'phone'           => '(254) 526-7161',
        'active'          => false,
        'created_at'      => Date::now('America/Chicago'),
      ]);
      // 3
      DB::table('users')->insert([
        'firstname'       => 'Mayborn Science Theater',
        'lastname'        => '',
        'email'           => 'planetarium@ctcd.edu',
        'password'        =>  bcrypt('Mayborn152'),
        'role_id'         => 6,
        'organization_id' => 2,
        'type'            => 'organization',
        'membership_id'   => 1,
        'address'         => '6200 W Central Texas Expwy',
        'city'            => 'Killeen',
        'state'           => 'Texas',
        'zip'             => '76549',
        'country'         => 'United States',
        'phone'           => '(254) 526-7161',
        'active'          => false,
        'created_at'      => Date::now('America/Chicago'),
      ]);
      // 4
      DB::table('users')->insert([
        'firstname'       => 'Central Texas College',
        'lastname'        => '',
        'email'           => 'contact@ctcd.edu',
        'password'        =>  bcrypt('Mayborn152'),
        'role_id'         => 6,
        'organization_id' => 3,
        'type'            => 'organization',
        'membership_id'   => 1,
        'address'         => '6200 W Central Texas Expwy',
        'city'            => 'Killeen',
        'state'           => 'Texas',
        'zip'             => '76549',
        'country'         => 'United States',
        'phone'           => '(254) 526-7161',
        'active'          => false,
        'created_at'      => Date::now('America/Chicago'),
      ]);
      // 5
      DB::table('users')->insert([
        'firstname'       => 'Donald',
        'lastname'        => 'Hubbs',
        'email'           => 'dhubbs@stu.ctcd.edu',
        'password'        => '$2y$10$2sq9LcPg2W6/iIKQ20J19OwDFxZmrhCgU0Z/MPY6EQw0qbGJuQImO',
        'role_id'         => 2,
        'organization_id' => 2,
        'type'            => 'individual',
        'membership_id'   => 1,
        'address'         => '6200 W Central Texas Expwy',
        'city'            => 'Killeen',
        'state'           => 'Texas',
        'zip'             => '76549',
        'country'         => 'United States',
        'phone'           => '(254) 526-7161',
        'active'          => false,
        'created_at'      => Date::now('America/Chicago'),
      ]);
      // 6
      DB::table('users')->insert([
        'firstname'       => 'David',
        'lastname'        => 'Cantwell',
        'email'           => 'somethingsomething@gmail.com',
        'password'        => '$2y$10$RMa8J6rGq1VfoA9jMFPH0.QO3e5bvaRU/S2p0/eqGKVy1Uta518tu',
        'role_id'         => 2,
        'organization_id' => 2,
        'type'            => 'individual',
        'membership_id'   => 1,
        'address'         => '6200 W Central Texas Expwy',
        'city'            => 'Killeen',
        'state'           => 'Texas',
        'zip'             => '76549',
        'country'         => 'United States',
        'phone'           => '(254) 526-7161',
        'active'          => false,
        'created_at'      => Date::now('America/Chicago'),
      ]);
    }
}
