<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
  static $password;

  return [
    'firstname' => $faker->firstName,
    'lastname' => $faker->lastName,
    'email' => $faker->unique()->safeEmail,
    'password' => $password ?: $password = bcrypt('secret'),
    'remember_token' => str_random(10),
    'role_id'         => 2,
    'organization_id' => 1,
    'type'            => 'individual',
    'membership_id'   => 1,
    'address'         => '6200 W Central Texas Expwy',
    'city'            => 'Killeen',
    'state'           => 'Texas',
    'zip'             => '76549',
    'country'         => 'United States',
    'phone'           => '(254) 526-7161',
    'active'          => true,
    'staff'           => false,
    'creator_id'      => 1,
    'created_at'      => Date::now('America/Chicago'),
  ];
});
