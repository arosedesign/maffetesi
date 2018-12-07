<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AggiungiDefaultNullableRelazioni extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('opzioni_tabelle', function (Blueprint $table) {
            $table->unsignedInteger('table_id')->nullable()->default(NULL)->change();

        });

        Schema::table('domande', function (Blueprint $table) {
            $table->unsignedInteger('table_id')->nullable()->default(NULL)->change();
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
