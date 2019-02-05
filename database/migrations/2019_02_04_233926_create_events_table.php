<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Filesystem\Filesystem;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('creator_id');
            $table->string('header_url')->nullable();
            $table->string('description')->nullable();
            $table->string('start_date');
            $table->string('start_time')->nullable();
            $table->string('end_date')->nullable();
            $table->string('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations and clear out the events/ image directory.
     *
     * @return void
     */
    public function down()
    {
        $fs = new Filesystem();
        $fs->cleanDirectory('storage/app/public/events');
        Schema::dropIfExists('events');
    }
}
