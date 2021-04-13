<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing roles table fields and data
     *
     * @return void
     */
    public function test_roles_table()
    {
        $this->seed(Seeders\RolesTableSeeder::class);

        $this->assertDatabaseCount('roles', 8);
    }

    /**
     * Testing organization types table fields and data
     *
     * @return void
     */
    public function test_organization_types_table()
    {
        $this->seed(Seeders\OrganizationTypesTableSeeder::class);

        $this->assertDatabaseCount('organization_types', 5);
    }

    /**
     * Testing member types table fields and data
     *
     * @return void
     */
    public function test_member_types_table()
    {
        $this->seed(Seeders\MemberTypesTableSeeder::class);

        $this->assertDatabaseCount('member_types', 4);
    }

    /**
     * Testing organizations table fields and data
     *
     * @return void
     */
    public function test_organizations_table()
    {
        $this->seed(Seeders\OrganizationsTableSeeder::class);

        $this->assertDatabaseCount('organizations', 2);
    }

    /**
     * Testing members table fields and data
     *
     * @return void
     */
    public function test_members_table()
    {
        $this->seed(Seeders\MembersTableSeeder::class);

        $this->assertDatabaseCount('members', 1);
    }
    
    /**
     * Testing users table fields and data
     *
     * @return void
     */
    public function test_users_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);

        $this->assertDatabaseCount('users', 3);
    }

    /**
     * Testing show types table fields and data
     *
     * @return void
     */
    public function test_show_types_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\ShowTypesTableSeeder::class);

        $this->assertDatabaseCount('show_types', 3);
    }


    /**
     * Testing shows table fields and data
     *
     * @return void
     */
    public function test_shows_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\ShowsTableSeeder::class);
        
        $this->assertDatabaseCount('shows', 3);
    }

    /**
     * Testing payment methods table fields and data
     *
     * @return void
     */
    public function test_payment_methods_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\PaymentMethodsTableSeeder::class);

        $this->assertDatabaseCount('payment_methods', 8);
    }

    /**
     * Testing event types table fields and data
     *
     * @return void
     */
    public function test_event_types_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\EventTypesSeeder::class);
        
        $this->assertDatabaseCount('event_types', 5);
    }

    /**
     * Testing events table fields and data
     *
     * @return void
     */
    public function test_events_table_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\EventTypesSeeder::class);
        $this->seed(Seeders\ShowsTableSeeder::class);
        $this->seed(Seeders\EventsTableSeeder::class);

        $this->assertDatabaseCount('events', 1);
    }

    /**
     * Testing ticket types table fields and data
     *
     * @return void
     */
    public function test_ticket_types_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\EventTypesSeeder::class);
        $this->seed(Seeders\ShowsTableSeeder::class);
        $this->seed(Seeders\EventsTableSeeder::class);
        $this->seed(Seeders\TicketTypesTableSeeder::class);

        $this->assertDatabaseCount('events', 1);
    }

    /**
     * Testing settings table fields and data
     *
     * @return void
     */
    public function test_settings_table()
    {
        $this->seed(Seeders\SettingsTableSeeder::class);

        $this->assertDatabaseCount('settings', 1);
    }

    /**
     * Testing categories table fields and data
     *
     * @return void
     */
    public function test_category_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\CategoriesTableSeeder::class);

        $this->assertDatabaseCount('categories', 1);
    }

    /**
     * Testing product types table fields and data
     *
     * @return void
     */
    public function test_product_types_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\ProductTypesTableSeeder::class);

        $this->assertDatabaseCount('product_types', 1);
    }

    /**
     * Testing products table fields and data
     *
     * @return void
     */
    public function test_products_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\ProductTypesTableSeeder::class);
        $this->seed(Seeders\ProductsTableSeeder::class);

        $this->assertDatabaseCount('products', 3);
    }

    /**
     * Testing roles access control table fields and data
     *
     * @return void
     */
    public function test_roles_access_control_table()
    {
        $this->seed(Seeders\RolesTableSeeder::class);
        $this->seed(Seeders\RolesAccessControlTableSeeder::class);

        $this->assertDatabaseCount('roles_access_control', 8);
    }

    /**
     * Testing positions table fields and data
     *
     * @return void
     */
    public function test_grades_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\GradesTableSeeder::class);

        $this->assertDatabaseCount('grades', 16);
    }

    public function test_positions_table()
    {
        $this->seed(Seeders\UsersTableSeeder::class);
        $this->seed(Seeders\PositionsTableSeeder::class);

        $this->assertDatabaseCount('positions', 3);
    }
}
