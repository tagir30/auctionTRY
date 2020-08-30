<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lot;
use Faker\Generator as Faker;

$factory->define(Lot::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
        'description' => $faker->text(200),
        'startingPrice' => $faker->randomNumber(),
        'pathImage' => config('constants.PATH_DEFAULT_IMAGE'),
        'timeLeft' => $faker->dateTimeBetween(now(), now()->addDays(10)),
        'status' => $faker->randomKey([0, 1]),
    ];
});
