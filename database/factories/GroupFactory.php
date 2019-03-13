<?php

use Faker\Generator as Faker;
use App\FileHelper;

$factory->define(App\Group::class, function (Faker $faker) {
    $filehelper = new FileHelper;
    return [
        'name' => $faker->company,
        'avatar_url' => $filehelper->getRandomImageFromDirectory('default_avatars','avatars'),
        'header_url' => $filehelper->getRandomImageFromDirectory('default_headers','groups'),
        'demo' => true
    ];
});
