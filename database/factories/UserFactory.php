<?php

use Faker\Generator as Faker;
use App\FileHelper;

$factory->define(App\User::class, function (Faker $faker) {
    $filehelper = new FileHelper;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'demo' => true,
        'avatar_url' => $filehelper->getRandomImageFromDirectory('default_avatars','avatars')
    ];
});
