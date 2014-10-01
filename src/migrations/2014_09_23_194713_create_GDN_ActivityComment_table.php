<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNActivityCommentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_ActivityComment', function(Blueprint $table)
        {
            $table->integer('ActivityCommentID', true);
            $table->integer('ActivityID')->index('FK_ActivityComment_ActivityID');
            $table->text('Body');
            $table->string('Format', 20);
            $table->integer('InsertUserID');
            $table->dateTime('DateInserted');
            $table->string('InsertIPAddress', 15)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_ActivityComment');
    }

}
