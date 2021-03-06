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
            $table->string('nome')->default(NULL)->change();
            $table->text('descrizione')->default(NULL)->change();
            $table->string('tipo')->default(NULL)->change();
        });


        Schema::table('opzioni_tabelle', function (Blueprint $table) {
            $table->string('nome')->default(NULL)->change();
            $table->integer('valore')->default(NULL)->change();
            $table->string('tipo')->default(NULL)->change();
        });

        Schema::table('domande', function (Blueprint $table) {
            $table->string('domanda')->default(NULL)->change();
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
