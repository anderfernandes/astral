<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::createFromTimestampUTC(0)->toDateTimeString();
        // 1
        DB::table('users')->insert([
        'firstname'       => 'Walk-up',
        'lastname'        => '',
        'email'           => 'walkup@walkup.com',
        'password'        =>  bcrypt(Str::random()),
        'role_id'         => 1,
        'organization_id' => 1,
        'type'            => 'walk-up',
        'created_at'      => $date,
      ]);
        // 2
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
        'created_at'      => $date,
      ]);
        // 3
        DB::table('users')->insert([
        'firstname'       => 'admin',
        'email'           => 'admin@astral',
        'password'        =>  bcrypt('admin'),
        'role_id'         => 2,
        'organization_id' => 2,
        'type'            => 'individual',
        'membership_id'   => 1,
        'active'          => true,
        'staff'           => true,
        'created_at'      => $date,
      ]);
    }
}
