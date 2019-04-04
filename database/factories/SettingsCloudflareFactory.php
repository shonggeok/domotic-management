<?php

use \App\Repositories\Settings\SettingsCloudflareRepository;
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

$factory->define(SettingsCloudflareRepository::class, function (Faker $faker) {
    return [
        'api_key' => $faker->asciify('**************'),
        'email' => $faker->email(),
        'domain_list' => $faker->domainName()
    ];
});
