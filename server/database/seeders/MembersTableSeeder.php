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
    public function run(): void
    {
        // 1
        DB::table('members')->insert([
            'type_id' => 1,
            'start' => Carbon::createFromTimestampUTC(0),
            'end' => Carbon::createFromTimestampUTC(0),
            'creator_id' => 1,
            'created_at' => now(),
            'primary_id' => 1,
        ]);
    }
}
