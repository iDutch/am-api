<?php

use Faker\Generator as Faker;

$factory->define(App\Entry::class, function (Faker $faker) {
    return [
        'time' => $faker->time('H:i:s', 'now'),
        'red' => $faker->randomNumber(2),
        'green' => $faker->randomNumber(2),
        'blue' => $faker->randomNumber(2),
        'warmwhite' => $faker->randomNumber(2),
        'coldwhite' => $faker->randomNumber(2),
    ];
});
