<?php

use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('organizations')->insert([
          'name'        => 'No Organization',
          'address'     => '6200 W Central Texas Expwy',
          'city'        => 'Killeen',
          'state'       => 'Texas',
          'zip'         => '76549',
          'country'     => 'United States',
          'phone'       => '(254) 526-7161',
          'email'       => 'astral@astral.com',
          'type_id'     => 1,
          'created_at'  => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
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
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        DB::table('organizations')->insert([
          'name'        => 'Central Texas College',
          'address'     => '6200 W Central Texas Expwy',
          'city'        => 'Killeen',
          'state'       => 'Texas',
          'zip'         => '76549',
          'country'     => 'United States',
          'phone'       => '(254) 526-7161',
          'email'       => 'admissions@ctcd.edu',
          'type_id'     => 3,
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);
    }
}
