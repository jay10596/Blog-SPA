<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Favourite;
use App\Question;
use App\User;
use Faker\Generator as Faker;

$factory->define(Favourite::class, function (Faker $faker) {
    return [
        'question_id' => $faker->unique()->numberBetween(1,10),
        'user_id' => $faker->numberBetween(1,10)
    ];
});
