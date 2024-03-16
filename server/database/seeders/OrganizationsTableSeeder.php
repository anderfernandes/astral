<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('organizations')->insert([
            'name'        => 'No Organization',
            'email'       => 'astral@astral',
            'created_at'  => Carbon::createFromTimestampUTC(0),
        ]);

        DB::table('organizations')->insert([
            'name'        => 'Mayborn Science Theater',
            'address'     => '6200 W Central Texas Expwy',
            'city'        => 'Killeen',
            'state'       => 'Texas',
            'zip'         => '76549',
            'country'     => 'United States',
            'phone'       => '(254) 526-7161',
            'email'       => 'planetarium@ctcd.edu',
            'type_id'     => 2,
            'created_at'  => now(),
        ]);
    }
}
