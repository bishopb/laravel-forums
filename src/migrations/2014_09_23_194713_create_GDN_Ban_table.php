<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNBanTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Ban', function(Blueprint $table)
        {
            $table->integer('BanID', true);
            $table->enum('BanType', array('IPAddress','Name','Email'));
            $table->string('BanValue', 50);
            $table->string('Notes', 255)->nullable();
            $table->integer('CountUsers')->unsigned()->default(0);
            $table->integer('CountBlockedRegistrations')->unsigned()->default(0);
            $table->integer('InsertUserID');
            $table->dateTime('DateInserted');
            $table->unique(['BanType','BanValue'], 'UX_Ban');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Ban');
    }

}
