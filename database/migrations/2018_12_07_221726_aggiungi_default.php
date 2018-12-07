<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AggiungiDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('elenco_tabelle', function (Blueprint $table) {
            $table->string('nome')->default(NULL);
            $table->text('descrizione')->default(NULL);
            $table->string('tipo')->default(NULL);
        });


        Schema::table('opzioni_tabelle', function (Blueprint $table) {
            $table->timestamps();
            $table->string('nome')->default(NULL);
            $table->unsignedInteger('table_id');
            $table->foreign('table_id')->references('id')->on('elenco_tabelle');
            $table->integer('valore')->default(NULL);
            $table->string('tipo')->default(NULL);
        });

        Schema::table('domande', function (Blueprint $table) {
            $table->string('domanda')->default(NULL);
            $table->unsignedInteger('table_id');
            $table->foreign('table_id')->references('id')->on('elenco_tabelle');
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
