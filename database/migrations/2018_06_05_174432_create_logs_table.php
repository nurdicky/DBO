<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('car_id');
            $table->unsignedInteger('owner_id');
            $table->unsignedInteger('driver_id')->nullable();
            $table->string('status', 10);
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('cars');
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->foreign('driver_id')->references('id')->on('drivers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
