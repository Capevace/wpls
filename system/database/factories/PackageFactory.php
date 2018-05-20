<?php

use Faker\Generator as Faker;

$factory->define(App\Package::class, function (Faker $faker) {
    return [
        'slug'           => $faker->unique()->slug,
        'name'           => $faker->unique()->company,
        'version'        => '0.0.0',
        'envato_item_id' => '21322102',
        'last_metadata'  => json_decode('{}')
    ];
});
