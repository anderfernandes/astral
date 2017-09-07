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
          'name'    => 'Mayborn Science Theater',
          'address' => '6200 W Central Texas Expwy',
          'city'    => 'Killeen',
          'state'   => 'Texas',
          'zip'     => '76549',
          'country' => 'United States',
          'phone'   => '254-526-7161',
          'type_id'    => 1,
        ]);

        DB::table('organizations')->insert([
          'name'    => 'Central Texas College',
          'address' => '6200 W Central Texas Expwy',
          'city'    => 'Killeen',
          'state'   => 'Texas',
          'zip'     => '76549',
          'country' => 'United States',
          'phone'   => '254-526-7161',
          'type_id'    => 2,
        ]);
    }
}
