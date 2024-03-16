<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketType;

class TicketTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        (new TicketType())->create([
            "name" => "Member",
            "price" => 0,
            "is_active" => true,
            "description" => "Member ticket for all event types.",
            "creator_id" => 1,
            "in_cashier" => true,
            "is_public" => true,
        ])->allowedEvents()->attach([2, 3, 4]);

        (new TicketType())->create([
            "name" => "Matinee",
            "price" => 5,
            "is_active" => true,
            "description" => "Matinee unique price ticket, any age.",
            "creator_id" => 1,
            "in_cashier" => true,
            "is_public" => true,
        ])->allowedEvents()->attach([2]);

        (new TicketType())->create([
            "name" => "Adult",
            "price" => 7,
            "is_active" => true,
            "description" => "Adult tickets for weekend shows.",
            "creator_id" => 1,
            "in_cashier" => true,
            "is_public" => true,
        ])->allowedEvents()->attach([3]);

        (new TicketType())->create([
            "name" => "Child",
            "price" => 6,
            "is_active" => true,
            "description" => "Child tickets for weekend shows.",
            "creator_id" => 1,
            "in_cashier" => true,
            "is_public" => true,
        ])->allowedEvents()->attach([3]);

        (new TicketType())->create([
            "name" => "Student",
            "price" => 5,
            "is_active" => true,
            "description" => "Student tickets, meant for field trips.",
            "creator_id" => 1,
            "in_cashier" => true,
            "is_public" => false,
        ])->allowedEvents()->attach([5]);

        (new TicketType())->create([
            "name" => "Teacher",
            "price" => 0,
            "is_active" => true,
            "description" => "Teacher tickets, meant for field trips.",
            "creator_id" => 1,
            "in_cashier" => true,
            "is_public" => false,
        ])->allowedEvents()->attach([5]);

        (new TicketType())->create([
            "name" => "Parent",
            "price" => 5,
            "is_active" => true,
            "description" => "Parent ticket, meant for field trips.",
            "creator_id" => 1,
            "in_cashier" => true,
            "is_public" => false,
        ])->allowedEvents()->attach([5]);
    }
}
