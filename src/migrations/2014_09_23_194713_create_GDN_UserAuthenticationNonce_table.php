<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserAuthenticationNonceTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserAuthenticationNonce', function(Blueprint $table)
        {
            $table->string('Nonce', 200)->primary();
            $table->string('Token', 128);
            $table->timestamp('Timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserAuthenticationNonce');
    }

}
