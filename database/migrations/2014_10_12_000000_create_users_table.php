<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Filesystem\Filesystem;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('notifications_last_read_at')->nullable();
            $table->string('password');
            $table->string('avatar_url')->nullable();
            $table->boolean('demo')->default(false);
            $table->boolean('account_setup')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations and clear out the avatars/ image directory.
     *
     * @return void
     */
    public function down()
    {
        $fs = new Filesystem();
        $fs->cleanDirectory('storage/app/public/avatars');
        Schema::dropIfExists('users');
    }
}
