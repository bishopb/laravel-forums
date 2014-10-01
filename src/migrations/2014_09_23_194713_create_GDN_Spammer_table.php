<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNSpammerTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Spammer', function(Blueprint $table)
        {
            $table->integer('UserID')->primary();
            $table->smallInteger('CountSpam')->unsigned()->default(0);
            $table->smallInteger('CountDeletedSpam')->unsigned()->default(0);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Spammer');
    }

}
