<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'type' => 'admin',
        'mobile' => $faker->phoneNumber,
        'email' => $faker->safeEmail,
        'email_verified_at' => $faker->dateTime(),
        'password' => bcrypt('00001111'),
        'image' => $faker->word,
        'remember_token' => Str::random(10),
    ];
});
