<?php

use Faker\Generator as Faker;

$usedDefaultSlug = false;

$factory->define(App\Models\Package::class, function (Faker $faker) use ($usedDefaultSlug) {
    if (!$usedDefaultSlug)
        $usedDefaultSlug = true;

    return [
        'slug'           => !$usedDefaultSlug ? 'test-slug' : $faker->unique()->slug,
        'name'           => $faker->unique()->company,
        'version'        => '0.0.0',
        'envato_item_id' => '21322102',
        'last_metadata'  => json_decode('{}')
    ];
});
