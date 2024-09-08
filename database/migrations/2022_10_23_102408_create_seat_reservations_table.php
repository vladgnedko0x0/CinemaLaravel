<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seat_reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("SessionID")->unsigned();
            $table->foreign('SessionID')->references('id')->on('movie_sessions');
            $table->bigInteger('ClientID')->unsigned();
            $table->foreign('ClientID')->references('id')->on('clients');
            $table->integer('CountBilets');
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
        Schema::dropIfExists('seat_reservations');
    }
};
