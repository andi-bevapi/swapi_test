<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('next');
            $table->string('previous');
            $table->bigInteger('cargo_capacity');
            $table->string('consumables');
            $table->integer('cost_in_credits');
            $table->integer('crew');
            $table->float('length');
            $table->string('manufacturer');
            $table->integer('max_atmosphering_speed');
            $table->string('model');
            $table->string('name');
            $table->integer('passengers');
            $table->json('pilots');
            $table->json('films');
            $table->string('url');
            $table->string('vehicle_class');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
