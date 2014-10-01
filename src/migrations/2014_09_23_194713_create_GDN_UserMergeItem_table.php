<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserMergeItemTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserMergeItem', function(Blueprint $table)
        {
            $table->integer('MergeID')->index('FK_UserMergeItem_MergeID');
            $table->string('Table', 30);
            $table->string('Column', 30);
            $table->integer('RecordID');
            $table->integer('OldUserID');
            $table->integer('NewUserID');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserMergeItem');
    }

}
