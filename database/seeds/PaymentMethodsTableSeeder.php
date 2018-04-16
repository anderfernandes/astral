<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('payment_methods')->insert([
          'name'        => 'Cash',
          'description' => 'Cash payments',
          'icon'        => 'money',
          'type'        => 'cash',
          'creator_id'  => 1,
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 2
        DB::table('payment_methods')->insert([
          'name'        => 'Check',
          'description' => 'Check payments',
          'icon'        => 'check',
          'type'        => 'check',
          'creator_id'  => 1,
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 3
        DB::table('payment_methods')->insert([
          'name'        => 'Visa',
          'description' => 'Visa payments',
          'icon'        => 'cc visa',
          'type'        => 'card',
          'creator_id'  => 1,
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 4
        DB::table('payment_methods')->insert([
          'name'        => 'Mastercard',
          'description' => 'Mastercard payments',
          'icon'        => 'cc mastercard',
          'type'        => 'card',
          'creator_id'  => 1,
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 5
        DB::table('payment_methods')->insert([
          'name'        => 'Discover',
          'description' => 'Discover payments',
          'icon'        => 'cc discover',
          'type'        => 'card',
          'creator_id'  => 1,
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 6
        DB::table('payment_methods')->insert([
          'name'        => 'American Express',
          'description' => 'American Express payments',
          'icon'        => 'cc amex',
          'type'        => 'card',
          'creator_id'  => 1,
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);
    }
}
