<?php

use Illuminate\Database\Seeder;

class OrganizationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('organization_types')->insert([
          'name'        => 'System',
          'description' => 'System category time.',
          'taxable'     => false,
          'created_at'  => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
        ]);

        DB::table('organization_types')->insert([
          'name'        => 'Non Profit',
          'description' => 'All non profit organizations should fall under this category.',
          'taxable'     => false,
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        DB::table('organization_types')->insert([
          'name'        => 'Community College',
          'description' => 'All 2 year colleges should fall under this category.',
          'taxable'     => false,
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);
    }
}
