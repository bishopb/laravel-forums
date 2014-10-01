<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserConversationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserConversation', function(Blueprint $table)
        {
            $table->integer('UserID');
            $table->integer('ConversationID')->index('FK_UserConversation_ConversationID');
            $table->integer('CountReadMessages')->default(0);
            $table->integer('LastMessageID')->nullable();
            $table->dateTime('DateLastViewed')->nullable();
            $table->dateTime('DateCleared')->nullable();
            $table->boolean('Bookmarked')->default(0);
            $table->boolean('Deleted')->default(0);
            $table->dateTime('DateConversationUpdated')->nullable();
            $table->primary(['UserID','ConversationID']);
            $table->index(['UserID','Deleted','DateConversationUpdated'], 'IX_UserConversation_Inbox');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserConversation');
    }

}
