<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Filesystem\Filesystem;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar_url')->nullable();
            $table->string('header_url')->nullable();
            $table->boolean('demo')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations and clear out the groups/ image directory.
     *
     * @return void
     */
    public function down()
    {
        $fs = new Filesystem();
        $fs->cleanDirectory('storage/app/public/groups');
        Schema::dropIfExists('groups');
    }
}
