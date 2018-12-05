<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColonneAnagrafiche extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('anagrafiche', function (Blueprint $table) {
			$table->char('sesso', 1);
			$table->integer('altezza');
			$table->integer('peso');
			$table->string('eta', 50);
			$table->string('livello', 50);
			$table->string('sport', 50);
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
