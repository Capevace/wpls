<?php

use Faker\Generator as Faker;

$factory->define(App\Models\License::class, function (Faker $faker) {
    return [
        'license_key'      => $faker->unique()->sha256,
        'package_id'       => '',
        'supported_until'  => $faker->dateTimeBetween('-2 months', '+1 year'),
        'customer_data'    => json_decode('{}'),
        'is_purchase_code' => false
    ];
});
