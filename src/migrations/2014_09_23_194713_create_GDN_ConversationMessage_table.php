<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNConversationMessageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_ConversationMessage', function(Blueprint $table)
        {
            $table->integer('MessageID', true);
            $table->integer('ConversationID')->index('FK_ConversationMessage_ConversationID');
            $table->text('Body');
            $table->string('Format', 20)->nullable();
            $table->integer('InsertUserID')->nullable()->index('FK_ConversationMessage_InsertUserID');
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
        Schema::drop('GDN_ConversationMessage');
    }

}
