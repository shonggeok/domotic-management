<?php

use \App\Repositories\Settings\SettingsUserRepository;
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

$factory->define(SettingsUserRepository::class, function (Faker $faker) {
    return [
        'option_key' => 'timezone',
        'option_value' => $faker->timezone()
    ];
});
