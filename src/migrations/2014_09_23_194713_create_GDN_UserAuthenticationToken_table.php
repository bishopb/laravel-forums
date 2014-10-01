<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserAuthenticationTokenTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserAuthenticationToken', function(Blueprint $table)
        {
            $table->string('Token', 128);
            $table->string('ProviderKey', 64);
            $table->string('ForeignUserKey')->nullable();
            $table->string('TokenSecret', 64);
            $table->enum('TokenType', array('request','access'));
            $table->boolean('Authorized');
            $table->timestamp('Timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('Lifetime');
            $table->primary(['Token','ProviderKey']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserAuthenticationToken');
    }

}
