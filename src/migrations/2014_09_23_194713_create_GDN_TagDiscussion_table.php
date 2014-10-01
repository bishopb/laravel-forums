<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNTagDiscussionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_TagDiscussion', function(Blueprint $table)
        {
            $table->integer('TagID');
            $table->integer('DiscussionID');
            $table->integer('CategoryID')->index('IX_TagDiscussion_CategoryID');
            $table->dateTime('DateInserted')->nullable();
            $table->primary(['TagID','DiscussionID']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_TagDiscussion');
    }

}
