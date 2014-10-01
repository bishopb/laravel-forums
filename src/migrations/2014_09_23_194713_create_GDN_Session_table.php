<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNSessionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Session', function(Blueprint $table)
        {
            $table->char('SessionID', 32)->primary();
            $table->integer('UserID')->default(0);
            $table->dateTime('DateInserted');
            $table->dateTime('DateUpdated');
            $table->string('TransientKey', 12);
            $table->text('Attributes')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Session');
    }

}
