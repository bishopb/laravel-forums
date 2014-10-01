<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNLogTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Log', function(Blueprint $table)
        {
            $table->integer('LogID', true);
            $table->enum('Operation', array('Delete','Edit','Spam','Moderate','Pending','Ban','Error'))->index('IX_Log_Operation');
            $table->enum('RecordType', array('Discussion','Comment','User','Registration','Activity','ActivityComment','Configuration','Group'))->index('IX_Log_RecordType');
            $table->integer('TransactionLogID')->nullable();
            $table->integer('RecordID')->nullable()->index('IX_Log_RecordID');
            $table->integer('RecordUserID')->nullable();
            $table->dateTime('RecordDate');
            $table->string('RecordIPAddress', 15)->nullable()->index('IX_Log_RecordIPAddress');
            $table->integer('InsertUserID');
            $table->dateTime('DateInserted');
            $table->string('InsertIPAddress', 15)->nullable();
            $table->string('OtherUserIDs', 255)->nullable();
            $table->dateTime('DateUpdated')->nullable();
            $table->integer('ParentRecordID')->nullable()->index('IX_Log_ParentRecordID');
            $table->integer('CategoryID')->nullable()->index('FK_Log_CategoryID');
            $table->text('Data')->nullable();
            $table->integer('CountGroup')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Log');
    }

}
