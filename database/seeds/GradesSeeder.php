<?php

use Illuminate\Database\Seeder;

class GradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('grades')->insert([
          'name'           => 'Pre-K',
          'description'    => 'Pre-K students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => 'Kindergarten',
          'description'    => 'Kindergarten students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '1st',
          'description'    => 'First grade students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '2nd',
          'description'    => 'Second grade students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '3rd',
          'description'    => 'Third grade students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '4th',
          'description'    => 'Fourth grade students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '5th',
          'description'    => 'Fifth grade students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '6th',
          'description'    => 'Sixth grade students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '7th',
          'description'    => 'Seventh grade students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '8th',
          'description'    => 'Eight grade students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '9th',
          'description'    => 'Ninth grade students. High School freshmen.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '10th',
          'description'    => 'Tenth grade students. High School sophomores.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '11th',
          'description'    => 'Eleventh grade students. High School juniors.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => '12th',
          'description'    => 'Twelveth grade students. High School seniors.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => 'College/University',
          'description'    => 'College/University students.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
        DB::table('grades')->insert([
          'name'           => 'Senior Citizens',
          'description'    => 'Senior citizens.',
          'creator_id'     => 1,
          'created_at'     => Date::now()->toDateTimeString(),
        ]);
    }
}
