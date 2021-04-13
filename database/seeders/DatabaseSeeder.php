<?php

namespace Database\Seeders;

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
        $this->call([
          RolesTableSeeder::class,
          OrganizationTypesTableSeeder::class,
          MemberTypesTableSeeder::class,
          OrganizationsTableSeeder::class,
          MembersTableSeeder::class,
          UsersTableSeeder::class,
          ShowTypesTableSeeder::class,
          ShowsTableSeeder::class,
          PaymentMethodsTableSeeder::class,
          EventTypesSeeder::class,
          EventsTableSeeder::class,
          TicketTypesTableSeeder::class,
          SettingsTableSeeder::class,
          CategoriesTableSeeder::class,
          ProductTypesTableSeeder::class,
          ProductsTableSeeder::class,
          RolesAccessControlTableSeeder::class,
          GradesTableSeeder::class,
          PositionsTableSeeder::class,
        ]);
    }
}
