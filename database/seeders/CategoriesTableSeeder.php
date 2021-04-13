<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('categories')->insert([
            'name'        => 'announcements',
            'description' => 'Staff announcements.',
            'creator_id'  => 2,
            'created_at'  => now(config('app.timezone')),
        ]);
    }
}
