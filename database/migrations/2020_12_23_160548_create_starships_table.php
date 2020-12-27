<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('starships', function (Blueprint $table) {
            $table->id();
            $table->string('next');
            $table->string('previous');
            $table->string('name');
            $table->string('model');
            $table->string('starship_class');
            $table->string('manufacturer');
            $table->bigInteger('cost_in_credits');
            $table->integer('length');
            $table->integer('crew');
            $table->integer('passengers');
            $table->string('max_atmosphering_speed');
            $table->float('hyperdrive_rating');
            $table->string('mglt');
            $table->bigInteger('cargo_capacity');
            $table->string('consumables');
            $table->json('films');
            $table->json('pilots');
            $table->string('url');
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
        Schema::dropIfExists('starships');
    }
}
