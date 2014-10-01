<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNConversationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Conversation', function(Blueprint $table)
        {
            $table->integer('ConversationID', true);
            $table->string('Type', 10)->nullable()->index('IX_Conversation_Type');
            $table->string('ForeignID', 40)->nullable();
            $table->string('Subject', 100)->nullable();
            $table->string('Contributors', 255);
            $table->integer('FirstMessageID')->nullable()->index('FK_Conversation_FirstMessageID');
            $table->integer('InsertUserID')->index('FK_Conversation_InsertUserID');
            $table->dateTime('DateInserted')->nullable()->index('FK_Conversation_DateInserted');
            $table->string('InsertIPAddress', 15)->nullable();
            $table->integer('UpdateUserID')->index('FK_Conversation_UpdateUserID');
            $table->dateTime('DateUpdated');
            $table->string('UpdateIPAddress', 15)->nullable();
            $table->integer('CountMessages')->default(0);
            $table->integer('CountParticipants')->default(0);
            $table->integer('LastMessageID')->nullable();
            $table->integer('RegardingID')->nullable()->index('IX_Conversation_RegardingID');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Conversation');
    }

}
