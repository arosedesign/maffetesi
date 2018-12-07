<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AggiungiNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('elenco_tabelle', function (Blueprint $table) {
            $table->string('nome')->nullable()->change();
            $table->text('descrizione')->nullable()->change();
            $table->string('tipo')->nullable()->change();
        });


        Schema::table('opzioni_tabelle', function (Blueprint $table) {
            $table->string('nome')->nullable()->change();
            $table->integer('valore')->nullable()->change();
            $table->string('tipo')->nullable()->change();
        });

        Schema::table('domande', function (Blueprint $table) {
            $table->string('domanda')->nullable()->change();
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
