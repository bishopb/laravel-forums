<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNRegardingTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Regarding', function(Blueprint $table)
        {
            $table->integer('RegardingID', true);
            $table->string('Type', 255)->index('FK_Regarding_Type');
            $table->integer('InsertUserID');
            $table->dateTime('DateInserted');
            $table->string('ForeignType', 32);
            $table->integer('ForeignID');
            $table->text('OriginalContent')->nullable();
            $table->string('ParentType', 32)->nullable();
            $table->integer('ParentID')->nullable();
            $table->string('ForeignURL', 255)->nullable();
            $table->text('Comment');
            $table->integer('Reports')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Regarding');
    }

}
