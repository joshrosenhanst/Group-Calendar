<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'text' => $faker->realText(150),
        'user_id' => App\User::first(),
        'commentable_id' => App\Group::first(),
        'commentable_type' => App\Group::class
    ];
});
