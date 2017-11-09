<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('members')->insert([
          'member_type_id' => 1,
          'user_id'        => 1,
          'start'          => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
          'end'            => Date::create(1970, 1, 1, 0, 0, 0, 'America/Chicago')->toDateTimeString(),
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
    }
}
