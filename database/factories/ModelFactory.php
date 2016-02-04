<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Email::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->email,
    ];
});


$factory->define(App\Guest::class, function (Faker\Generator $faker) {
    return [
        'identifier' => array_any([$faker->ipv4,$faker->ipv6]),
    ];
});


$factory->define(App\Identifier::class, function (Faker\Generator $faker) {
    $selectedClass = array_any([App\User::class,App\Email::class,App\Guest::class]);
    return [
        'type' => $selectedClass,
        'value' => rand(1000,9999),
    ];
});

$factory->define(App\PostIt::class, function (Faker\Generator $faker) {
    return [
        'identifier_id'=>rand(1000,9999),
        'message'=>implode(' ',$faker->sentences),
        'coordinates'=>[$faker->latitude,$faker->longitude],
        'status'=>rand(1,10)
    ];
});

$factory->define(App\Vote::class, function (Faker\Generator $faker) {
    return [
        'identifier_id'=>rand(1000,9999),
        'postit_id'=>rand(1000,9999),
        'value'=>array_any([1,-1])
    ];
});