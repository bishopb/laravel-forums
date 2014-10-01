<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserDiscussionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserDiscussion', function(Blueprint $table)
        {
            $table->integer('UserID');
            $table->integer('DiscussionID')->index('FK_UserDiscussion_DiscussionID');
            $table->float('Score', 10, 0)->nullable();
            $table->integer('CountComments')->default(0);
            $table->dateTime('DateLastViewed')->nullable();
            $table->boolean('Dismissed')->default(0);
            $table->boolean('Bookmarked')->default(0);
            $table->boolean('Participated')->default(0);
            $table->primary(['UserID','DiscussionID']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserDiscussion');
    }

}
