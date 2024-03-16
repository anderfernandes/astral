<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1
        DB::table('grades')->insert([
            'name'           => 'Pre-K',
            'description'    => 'Pre-K students.',
            'creator_id'     => 1,
            'created_at'     => now(),
        ]);

        DB::table('grades')->insert([
            'name'           => 'Kindergarten',
            'description'    => 'Kindergarten students.',
            'creator_id'     => 1,
            'created_at'     => now(),
        ]);
        DB::table('grades')->insert([
            'name'           => 'Elementary',
            'description'    => 'First grade students.',
            'creator_id'     => 1,
            'created_at'     => now(),
        ]);

        DB::table('grades')->insert([
            'name'           => 'Middle School',
            'description'    => 'Second grade students.',
            'creator_id'     => 1,
            'created_at'     => now(),
        ]);

        DB::table('grades')->insert([
            'name'           => 'High School',
            'description'    => 'Third grade students.',
            'creator_id'     => 1,
            'created_at'     => now(),
        ]);

        DB::table('grades')->insert([
            'name'           => 'College/University',
            'description'    => 'College/University students.',
            'creator_id'     => 1,
            'created_at'     => now(),
        ]);

        DB::table('grades')->insert([
            'name'           => 'Senior Citizens',
            'description'    => 'Senior citizens.',
            'creator_id'     => 1,
            'created_at'     => now(),
        ]);
    }
}
