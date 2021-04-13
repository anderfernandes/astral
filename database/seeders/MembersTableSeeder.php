<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::createFromTimestampUTC(0)
            ->toDateTimeString();
        // 1
        DB::table('members')->insert([
          'member_type_id' => 1,
          'start'          => $date,
          'end'            => $date,
          'creator_id'     => 1,
          'created_at'     => now(config('app.timezone'))->toDateTimeString(),
          'primary_id'     => 1,
        ]);
    }
}
