<?php

use Illuminate\Database\Seeder;

class RolesAccessControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('roles_access_control')->insert([
          'dashboard'     => null,
          'shows'         => null,
          'products'      => null,
          'calendar'      => null,
          'sales'         => null,
          'reports'       => null,
          'members'       => null,
          'users'         => null,
          'organizations' => null,
          'bulletin'      => null,
          'settings'      => null,
          'admin'         => false,
          'cashier'       => false,
          'role_id'       => 1,
          'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
        ]);
        // 2
        DB::table('roles_access_control')->insert([
          'dashboard'     => 'CRUD',
          'shows'         => 'CRUD',
          'products'      => 'CRUD',
          'calendar'      => 'CRUD',
          'sales'         => 'CRUD',
          'reports'       => 'CRUD',
          'members'       => 'CRUD',
          'users'         => 'CRUD',
          'organizations' => 'CRUD',
          'bulletin'      => 'CRUD',
          'settings'      => 'CRUD',
          'admin'         => true,
          'cashier'       => true,
          'role_id'       => 2,
          'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
        ]);
        // 3
        DB::table('roles_access_control')->insert([
          'dashboard'     => 'R',
          'shows'         => 'CRU',
          'products'      => 'R',
          'calendar'      => 'R',
          'sales'         => 'CRU',
          'reports'       => 'R',
          'members'       => 'CRU',
          'users'         => 'CRU',
          'organizations' => 'CRU',
          'bulletin'      => 'CRU',
          'settings'      => null,
          'admin'         => true,
          'cashier'       => true,
          'role_id'       => 3,
          'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
        ]);
        // 4
        DB::table('roles_access_control')->insert([
          'dashboard'     => 'R',
          'shows'         => 'R',
          'products'      => 'R',
          'calendar'      => 'R',
          'sales'         => 'CRU',
          'reports'       => 'R',
          'members'       => 'CRU',
          'users'         => 'CRU',
          'organizations' => 'CRU',
          'bulletin'      => 'CRU',
          'settings'      => null,
          'admin'         => true,
          'cashier'       => true,
          'role_id'       => 4,
          'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
        ]);
        // 5
        DB::table('roles_access_control')->insert([
          'dashboard'     => 'R',
          'shows'         => null,
          'products'      => null,
          'calendar'      => null,
          'sales'         => null,
          'reports'       => null,
          'members'       => null,
          'users'         => null,
          'organizations' => null,
          'bulletin'      => null,
          'settings'      => null,
          'admin'         => false,
          'cashier'       => false,
          'role_id'       => 5,
          'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
        ]);
        // 6
        DB::table('roles_access_control')->insert([
          'dashboard'     => 'R',
          'shows'         => null,
          'products'      => null,
          'calendar'      => null,
          'sales'         => null,
          'reports'       => null,
          'members'       => null,
          'users'         => null,
          'organizations' => null,
          'bulletin'      => null,
          'settings'      => null,
          'admin'         => false,
          'cashier'       => false,
          'role_id'       => 6,
          'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
        ]);
        // 7
        DB::table('roles_access_control')->insert([
          'dashboard'     => null,
          'shows'         => null,
          'products'      => null,
          'calendar'      => null,
          'sales'         => null,
          'reports'       => null,
          'members'       => null,
          'users'         => null,
          'organizations' => null,
          'bulletin'      => null,
          'settings'      => null,
          'admin'         => false,
          'cashier'       => false,
          'role_id'       => 7,
          'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
        ]);
        // 8
        DB::table('roles_access_control')->insert([
          'dashboard'     => null,
          'shows'         => null,
          'products'      => null,
          'calendar'      => null,
          'sales'         => null,
          'reports'       => null,
          'members'       => null,
          'users'         => null,
          'organizations' => null,
          'bulletin'      => null,
          'settings'      => null,
          'admin'         => false,
          'cashier'       => false,
          'role_id'       => 8,
          'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
        ]);
    }
}
