<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserMetaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserMeta', function(Blueprint $table)
        {
            $table->integer('UserID');
            $table->string('Name')->index('IX_UserMeta_Name');
            $table->text('Value')->nullable();
            $table->primary(['UserID','Name']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserMeta');
    }

}
