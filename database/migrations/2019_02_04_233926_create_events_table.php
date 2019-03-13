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
            $table->unsignedInteger('updater_id')->nullable();
            $table->string('location_place_id')->nullable();
            $table->string('location_name')->nullable();
            $table->string('location_formatted_address')->nullable();
            $table->string('location_city')->nullable();
            $table->string('location_state')->nullable();
            $table->string('location_map_url')->nullable();
            $table->string('header_url')->nullable();
            $table->string('description')->nullable();
            $table->date('start_date');
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
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
