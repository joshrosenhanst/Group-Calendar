<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Comment;
use App\User;
use App\Group;

class CommentFactory extends Factory
{
  use HasFactory;

  protected $model = Comment::class;

  public function definition()
  {
    return [
        'text' => $this->faker->realText(150),
        'user_id' => User::first(),
        'commentable_id' => Group::first(),
        'commentable_type' => Group::class
    ];
  }
}
