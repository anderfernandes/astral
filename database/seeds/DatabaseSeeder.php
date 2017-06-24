<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed database with sample data
        $this->call(UsersTableSeeder::class);
        $this->call(ShowsTableSeeder::class);
    }
}
