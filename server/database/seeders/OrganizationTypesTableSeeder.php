<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrganizationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('organization_types')->insert([
            'name'        => 'system',
            'description' => 'system',
            'taxable'     => false,
            'creator_id'  => 1,
            'created_at'  => Carbon::createFromTimestampUTC(0),
        ]);

        DB::table('organization_types')->insert([
            'name'        => 'Non Profit',
            'description' => 'All non profit organizations should fall under this category.',
            'taxable'     => false,
            'creator_id'  => 1,
            'created_at'  => Carbon::createFromTimestampUTC(0),
        ]);

        DB::table('organization_types')->insert([
            'name'        => 'Community College',
            'description' => 'All 2 year colleges should fall under this category.',
            'taxable'     => false,
            'creator_id'  => 1,
            'created_at'  => Carbon::createFromTimestampUTC(0),
        ]);

        DB::table('organization_types')->insert([
            'name'        => 'Public School',
            'description' => 'All public schools should be under this category',
            'taxable'     => false,
            'creator_id'  => 1,
            'created_at'  => Carbon::createFromTimestampUTC(0),
        ]);

        DB::table('organization_types')->insert([
            'name'        => 'Private School',
            'description' => 'All private schools should be under this category',
            'taxable'     => false,
            'creator_id'  => 1,
            'created_at'  => Carbon::createFromTimestampUTC(0),
        ]);
    }
}
