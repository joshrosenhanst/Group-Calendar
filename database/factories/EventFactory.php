<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use App\Group;
use App\Event;
use App\Facades\FileHelper;

class EventFactory extends Factory
{
  use HasFactory;

  protected $model = Event::class;

  public function definition()
  {
    $group = Group::first();
    $user = $group ? $group->users()->first() : null;

    return [
        'name' => $this->faker->name,
        'group_id' => $group ? $group->id : 1,
        'creator_id' => $user ? $user->id : 1,
        'location_name' => $this->faker->company,
        'location_formatted_address' => $this->faker->address,
        'location_city' => $this->faker->city,
        'location_state' => $this->faker->stateAbbr,
        'header_url' => FileHelper::getRandomImageFromDirectory('default_headers','events'),
        'description' => $this->faker->realText(150),
        'start_date' => $this->faker->date('Y-m-d'),
        'start_time' => $this->faker->time('H:i')
    ];
  }

  public function upcoming()
  {
    return $this->state(function(){
        return [
            'start_date' => Carbon::today()->addDays("26")->format("Y-m-d")
        ];
    });
}

  public function past()
  {
    return $this->state(function(){
        return [
            'start_date' => Carbon::today()->subWeeks("4")->format("Y-m-d")
        ];
    });
  }
}