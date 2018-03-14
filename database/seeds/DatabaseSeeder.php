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
        $this->call(RolesTableSeeder::class);
        $this->call(OrganizationTypesTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(MemberTypesTableSeeder::class);
        $this->call(MembersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ShowsTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(EventTypesSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(TicketTypesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
    }
}
