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
        Schema::create('clients_commentaries', function (Blueprint $table) {
            $table->id();
            $table->string("comment",600);
            $table->bigInteger("ClientID")->unsigned();
            $table->foreign("ClientID")->references("id")->on("Clients");
            $table->dateTime("Date");
            $table->bigInteger("MovieID")->unsigned();
            $table->foreign("MovieID")->references("id")->on("Movies");
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
        Schema::dropIfExists('clients_commentaries');
    }
};
