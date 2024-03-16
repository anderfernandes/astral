<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Settings Table Seeder
        DB::table('settings')->insert([
            'organization'              => 'Mayborn Science Theater',
            'seats'                     => 180,
            'tax'                       => 8.25,
            'created_at'                => now(),
            'website'                   => 'starsatnight.org',
            'email'                     => 'planetarium@ctcd.edu',
            'address'                   => 'Academic DR, Killeen, TX, 76549',
            'phone'                     => '(254) 526-1768',
            'fax'                       => '(254) 526-1799',
            'membership_card_width'     => 3.37,
            'membership_card_height'    => 2.13,
            'membership_number_length'  => 3,
            'cashier_customer_dropdown' => 1,
            'ticket_width'              => 5.63,
            'ticket_height'             => 1.97,
        ]);
    }
}
