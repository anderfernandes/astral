<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1
        DB::table('payment_methods')->insert([
            'name' => 'Cash',
            'description' => 'Cash payments',
            'icon' => 'money',
            'type' => 'cash',
            'creator_id' => 1,
            'created_at' => now(),
        ]);

        // 2
        DB::table('payment_methods')->insert([
            'name' => 'Check',
            'description' => 'Check payments',
            'icon' => 'check',
            'type' => 'check',
            'creator_id' => 1,
            'created_at' => now(),
        ]);

        // 3
        DB::table('payment_methods')->insert([
            'name' => 'Visa',
            'description' => 'Visa payments',
            'icon' => 'cc visa',
            'type' => 'card',
            'creator_id' => 1,
            'created_at' => now(),
        ]);

        // 4
        DB::table('payment_methods')->insert([
            'name' => 'Mastercard',
            'description' => 'Mastercard payments',
            'icon' => 'cc mastercard',
            'type' => 'card',
            'creator_id' => 1,
            'created_at' => now(),
        ]);

        // 5
        DB::table('payment_methods')->insert([
            'name' => 'Discover',
            'description' => 'Discover payments',
            'icon' => 'cc discover',
            'type' => 'card',
            'creator_id' => 1,
            'created_at' => now(),
        ]);

        DB::table('payment_methods')->insert([
            'name' => 'American Express',
            'description' => 'American Express payments',
            'icon' => 'cc amex',
            'type' => 'card',
            'creator_id' => 1,
            'created_at' => now(),
        ]);

        DB::table('payment_methods')->insert([
            'name' => 'Stripe',
            'description' => 'Stripe payments',
            'icon' => 'stripe',
            'type' => 'online',
            'creator_id' => 1,
            'created_at' => now(),
        ]);
    }
}
