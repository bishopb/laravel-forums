<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNMediaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Media', function(Blueprint $table)
        {
            $table->integer('MediaID', true);
            $table->string('Name', 255);
            $table->string('Path', 255);
            $table->string('Type', 128);
            $table->integer('Size');
            $table->integer('InsertUserID');
            $table->dateTime('DateInserted');
            $table->integer('ForeignID')->nullable();
            $table->string('ForeignTable', 24)->nullable();
            $table->smallInteger('ImageWidth')->unsigned()->nullable();
            $table->smallInteger('ImageHeight')->unsigned()->nullable();
            $table->smallInteger('ThumbWidth')->unsigned()->nullable();
            $table->smallInteger('ThumbHeight')->unsigned()->nullable();
            $table->string('ThumbPath', 255)->nullable();
            $table->index(['ForeignID','ForeignTable'], 'IX_Media_Foreign');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Media');
    }

}
