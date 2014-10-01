<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNDraftTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Draft', function(Blueprint $table)
        {
            $table->integer('DraftID', true);
            $table->integer('DiscussionID')->nullable()->index('FK_Draft_DiscussionID');
            $table->integer('CategoryID')->nullable()->index('FK_Draft_CategoryID');
            $table->integer('InsertUserID')->index('FK_Draft_InsertUserID');
            $table->integer('UpdateUserID');
            $table->string('Name', 100)->nullable();
            $table->string('Tags', 255)->nullable();
            $table->boolean('Closed')->default(0);
            $table->boolean('Announce')->default(0);
            $table->boolean('Sink')->default(0);
            $table->text('Body');
            $table->string('Format', 20)->nullable();
            $table->dateTime('DateInserted');
            $table->dateTime('DateUpdated')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Draft');
    }

}
