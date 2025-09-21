<?php

namespace Database\Factories;

use App\Group;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Facades\FileHelper;

class GroupFactory extends Factory
{
  use HasFactory;

  protected $model = Group::class;

  public function definition()
  {    
    return [
        'name' => $this->faker->company,
        'avatar_url' => FileHelper::getRandomImageFromDirectory('default_avatars','avatars'),
        'header_url' => FileHelper::getRandomImageFromDirectory('default_headers','groups'),
        'demo' => true
    ];
  }
}
