<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserAuthenticationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserAuthentication', function(Blueprint $table)
        {
            $table->string('ForeignUserKey');
            $table->string('ProviderKey', 64);
            $table->integer('UserID')->index('FK_UserAuthentication_UserID');
            $table->primary(['ForeignUserKey','ProviderKey']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserAuthentication');
    }

}
