<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1
        DB::table('roles')->insert([
            'name'        => 'Visitor',
            'description' => 'Visitor accounts.',
            'type'        => 'individuals',
            'staff'       => false,
            'created_at'  => now(),
        ]);
        // 2
        DB::table('roles')->insert([
            'name'        => 'Senior Staff',
            'description' => 'Senior Staff accounts.',
            'type'        => 'individuals',
            'staff'       => true,
            'created_at'  => now(),
        ]);
        // 3
        DB::table('roles')->insert([
            'name'        => 'Planetarium Lead Assistant',
            'description' => 'Planetarium Lead Assistant accounts.',
            'type'        => 'individuals',
            'staff'       => true,
            'created_at'  => now(),
        ]);
        // 4
        DB::table('roles')->insert([
            'name'        => 'Planetarium Assistant',
            'description' => 'Planetarium Assistant accounts.',
            'type'        => 'individuals',
            'staff'       => true,
            'created_at'  => now(),
        ]);
        // 5
        DB::table('roles')->insert([
            'name'        => 'Member',
            'description' => 'Member accounts',
            'type'        => 'members',
            'staff'       => false,
            'created_at'  => now(),
        ]);
        // 6
        DB::table('roles')->insert([
            'name'        => 'Community College',
            'description' => 'Community College accounts.',
            'type'        => 'organizations',
            'staff'       => false,
            'created_at'  => now(),
        ]);
        // 7
        DB::table('roles')->insert([
            'name'        => 'Teacher',
            'description' => 'Teacher accounts.',
            'type'        => 'individuals',
            'staff'       => false,
            'created_at'  => now(),
        ]);
    }
}
