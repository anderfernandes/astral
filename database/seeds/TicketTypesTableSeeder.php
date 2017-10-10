<?php

use Illuminate\Database\Seeder;

class TicketTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /* 1
      DB::table('ticket_types')->insert([
        'name'          => 'Adult Weekend',
        'description'   => 'Adult Weekend ticket',
        'active'        => 'true',
        'event_type_id' => 3,
        'price'         => 7.00,
        'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 2
      DB::table('ticket_types')->insert([
        'name'          => 'Children Weekend',
        'description'   => 'Children Weekend ticket',
        'active'        => 'true',
        'event_type_id' => 3,
        'price'         => 6.00,
        'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 3
      DB::table('ticket_types')->insert([
        'name'          => 'Matinee',
        'description'   => 'Matinee ticket',
        'active'        => 'true',
        'event_type_id' => 2,
        'price'         => 5.00,
        'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
      ]); */
    }
}
