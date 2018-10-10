<?php

use Illuminate\Database\Seeder;

class MemberTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // 1
      DB::table('member_types')->insert([
        'name'            => 'No Membership',
        'description'     => 'No membership',
        'price'           => 0,
        'duration'        => 0,
        'max_secondaries' => 0,
        'secondary_price' => 0,
        'creator_id'      => 1,
        'created_at'      => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 1
      DB::table('member_types')->insert([
        'name'            => 'Individual Membership',
        'description'     => 'Individual Membership',
        'price'           => 50,
        'duration'        => 365,
        'max_secondaries' => 1,
        'secondary_price' => 25,
        'creator_id'      => 1,
        'created_at'      => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 2
      DB::table('member_types')->insert([
        'name'            => 'Family Membership',
        'description'     => 'Family Membership',
        'price'           => 100,
        'duration'        => 365,
        'max_secondaries' => 2,
        'secondary_price' => 25,
        'creator_id'      => 1,
        'created_at'      => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 3
      DB::table('member_types')->insert([
        'name'            => 'Sponsor Membership',
        'description'     => 'Sponsor Membership',
        'price'           => 135,
        'duration'        => 365,
        'max_secondaries' => 4,
        'secondary_price' => 25,
        'creator_id'      => 1,
        'created_at'      => Date::now('America/Chicago')->toDateTimeString(),
      ]);
    }
}
