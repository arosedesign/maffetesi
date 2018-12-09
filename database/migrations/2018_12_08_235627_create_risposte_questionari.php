<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRisposteQuestionari extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impostazioni', function (Blueprint $table) {
            $table->increments('id');

            $table->text('utente')->nullable();

            $table->unsignedInteger('id_domanda')->nullable();
            $table->foreign('id_domanda')->references('id')->on('domande');

            $table->unsignedInteger('id_opzione')->nullable();
            $table->foreign('id_opzione')->references('id')->on('opzioni_tabelle');

            $table->text('risposta')->nullable();

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
        //
    }
}
