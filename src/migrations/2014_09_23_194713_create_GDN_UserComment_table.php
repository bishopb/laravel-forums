<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserCommentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserComment', function(Blueprint $table)
        {
            $table->integer('UserID');
            $table->integer('CommentID');
            $table->float('Score', 10, 0)->nullable();
            $table->dateTime('DateLastViewed')->nullable();
            $table->primary(['UserID','CommentID']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserComment');
    }

}
