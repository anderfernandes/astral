<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1
        DB::table('users')->insert([
            'firstname' => 'Walk-up',
            'lastname' => '',
            'email' => 'walkup@walkup.com',
            'password' => Hash::make(Str::random()),
            'role_id' => 1,
            'organization_id' => 1,
            'type' => 'walk-up',
            'created_at' => Carbon::createFromTimestampUTC(0),
        ]);
        // 2
        DB::table('users')->insert([
            'firstname' => 'Mayborn Science Theater',
            'lastname' => '',
            'email' => 'planetarium@ctcd.edu',
            'password' => Hash::make(Str::random()),
            'role_id' => 6,
            'organization_id' => 2,
            'type' => 'organization',
            'membership_id' => 1,
            'created_at' => Carbon::createFromTimestampUTC(0),
        ]);
        // 3
        DB::table('users')->insert([
            'firstname' => 'admin',
            'lastname' => 'admin',
            'email' => 'admin',
            'password' => bcrypt('admin'),
            'role_id' => 2,
            'organization_id' => 2,
            'type' => 'individual',
            'membership_id' => 1,
            'active' => true,
            'staff' => true,
            'created_at' => Carbon::createFromTimestampUTC(0),
        ]);
    }
}
