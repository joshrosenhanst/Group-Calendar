<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\FileHelper;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /*
        testCreateUser() - Test that the application can create a User model and database record.
        Check that the model properties are set properly and that the model accessor attributes are initialized.
    */
    public function testCreateUser(){
        $user = factory(\App\User::class)->create();

        $this->assertInstanceOf(\App\User::class, $user);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email
        ]);
        Storage::disk('public')->assertExists('avatars/'.$user->avatar_url);
        $this->assertIsString($user->avatar);
    }

    /*
        testUpdateUser() - Test that the application can update a user model and database record.
        Check that the model properties are updated properly and that the model accessor attributes are initialized.
    */
    public function testUpdateUser(){
        $filehelper = new FileHelper;
        $user = factory(\App\User::class)->create();

        $new_avatar_url = $filehelper->getRandomImageFromDirectory('default_avatars','avatars');
        $now_value = Carbon::now()->toDateTimeString();
        $updated_user = [
            'name' => 'New Name',
            'email' => 'new@email.test',
            'avatar_url' => $new_avatar_url,
            'password' => bcrypt('new_password'),
            'account_setup' => true,
            'notifications_last_read_at' => $now_value
        ];

        $user->update($updated_user);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email
        ]);

        $this->assertEquals($updated_user['name'], $user->name);
        $this->assertEquals($updated_user['email'], $user->email);
        $this->assertEquals($updated_user['avatar_url'], $user->avatar_url);
        $this->assertEquals($updated_user['password'], $user->password);
        $this->assertEquals($updated_user['account_setup'], $user->account_setup);
        $this->assertEquals($updated_user['notifications_last_read_at'], $user->notifications_last_read_at);

        Storage::disk('public')->assertExists('avatars/'.$user->avatar_url);
    }
}
