<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAnagrafichesTable extends Migration
{
    /**>ZZZZ
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::drop('anagrafiches');
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
