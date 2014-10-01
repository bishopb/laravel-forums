<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserMergeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserMerge', function(Blueprint $table)
        {
            $table->integer('MergeID', true);
            $table->integer('OldUserID')->index('FK_UserMerge_OldUserID');
            $table->integer('NewUserID')->index('FK_UserMerge_NewUserID');
            $table->dateTime('DateInserted');
            $table->integer('InsertUserID');
            $table->dateTime('DateUpdated')->nullable();
            $table->integer('UpdateUserID')->nullable();
            $table->text('Attributes')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserMerge');
    }

}
