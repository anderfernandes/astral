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
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 2
        DB::table('payment_methods')->insert([
          'name'        => 'Check',
          'description' => 'Check payments',
          'icon'        => 'check',
          'type'        => 'check',
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 3
        DB::table('payment_methods')->insert([
          'name'        => 'Visa',
          'description' => 'Visa payments',
          'icon'        => 'visa',
          'type'        => 'card',
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 4
        DB::table('payment_methods')->insert([
          'name'        => 'Mastercard',
          'description' => 'Mastercard payments',
          'icon'        => 'mastercard',
          'type'        => 'card',
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 5
        DB::table('payment_methods')->insert([
          'name'        => 'Discover',
          'description' => 'Discover payments',
          'icon'        => 'discover',
          'type'        => 'card',
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);
    }
}
