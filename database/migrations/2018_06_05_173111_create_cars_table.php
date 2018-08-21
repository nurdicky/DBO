<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('car_type');
            $table->string('car_plat_number');
            $table->string('car_frame_number');
            $table->string('car_machine_number');
            $table->string('car_rute');
            $table->text('car_image');
            $table->integer('owner_id')->unsigned();
            $table->string('car_barcode')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('owners');
                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
