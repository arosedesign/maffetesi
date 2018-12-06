<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixTabelle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elencotabelle', function (Blueprint $table) {
            $table->string('nome');
            $table->text('descrizione');
            $table->string('tipo');
        });

        Schema::rename('elencotabelle', 'elenco_tabelle');

        Schema::table('opzioni_tabelle', function (Blueprint $table) {
            $table->timestamps();
            $table->string('nome');
            $table->unsignedInteger('table_id');
            $table->foreign('table_id')->references('id')->on('elenco_tabelle');
            $table->integer('valore');
            $table->string('tipo');
        });

        Schema::table('domande', function (Blueprint $table) {
            $table->string('domanda');
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
