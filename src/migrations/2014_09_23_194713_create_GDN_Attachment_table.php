<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNAttachmentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Attachment', function(Blueprint $table)
        {
            $table->integer('AttachmentID', true);
            $table->string('Type', 64);
            $table->string('ForeignID', 50)->index('IX_Attachment_ForeignID');
            $table->integer('ForeignUserID')->index('FK_Attachment_ForeignUserID');
            $table->string('Source', 64);
            $table->string('SourceID', 32);
            $table->string('SourceURL', 255);
            $table->text('Attributes')->nullable();
            $table->dateTime('DateInserted');
            $table->integer('InsertUserID')->index('FK_Attachment_InsertUserID');
            $table->string('InsertIPAddress', 64);
            $table->dateTime('DateUpdated')->nullable();
            $table->integer('UpdateUserID')->nullable();
            $table->string('UpdateIPAddress', 15)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Attachment');
    }

}
