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
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 2
        DB::table('payment_methods')->insert([
          'name'        => 'Check',
          'description' => 'Check payments',
          'icon'        => 'check',
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);

        // 3
        DB::table('payment_methods')->insert([
          'name'        => 'Visa',
          'description' => 'Visa payments',
          'icon'        => 'visa',
          'created_at'  => Date::now('America/Chicago')->toDateTimeString(),
        ]);
    }
}
