<?php

use Faker\Generator as Faker;
use App\FileHelper;
use Illuminate\Support\Carbon;

$factory->define(App\Event::class, function (Faker $faker) {
    $filehelper = new FileHelper;
    $group = \App\Group::first();
    $user = $group ? $group->users()->first() : null;
    return [
        'name' => $faker->name,
        'group_id' => $group ? $group->id : 1,
        'creator_id' => $user ? $user->id : 1,
        'location_name' => $faker->company,
        'location_formatted_address' => $faker->address,
        'location_city' => $faker->city,
        'location_state' => $faker->stateAbbr,
        'header_url' => $filehelper->getRandomImageFromDirectory('default_headers','events'),
        'description' => $faker->realText(150),
        'start_date' => $faker->date('Y-m-d'),
        'start_time' => $faker->time('H:i')
    ];
});

$factory->state(App\Event::class, 'upcoming', function($faker){
    return [
        'start_date' => Carbon::today()->addDays("26")->format("Y-m-d")
    ];
});

$factory->state(App\Event::class, 'past', function($faker){
    return [
        'start_date' => Carbon::today()->subWeeks("4")->format("Y-m-d")
    ];
});