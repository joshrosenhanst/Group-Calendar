<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'avatar_url' => $faker->unique()->image('storage/app/public/groups',600,450,null,false),
        'demo' => true
    ];
});
