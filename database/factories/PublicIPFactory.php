<?php

use \App\Repositories\PublicIPRepository;
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

$factory->define(PublicIPRepository::class, function (Faker $faker) {
    return [
        'ip_address' => $faker->ipv4,
        'created_at' => now(),
        'updated_at' => now()
    ];
});
