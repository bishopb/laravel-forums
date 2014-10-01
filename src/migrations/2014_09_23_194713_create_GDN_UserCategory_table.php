<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserCategoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserCategory', function(Blueprint $table)
        {
            $table->integer('UserID');
            $table->integer('CategoryID');
            $table->dateTime('DateMarkedRead')->nullable();
            $table->boolean('Unfollow')->default(0);
            $table->primary(['UserID','CategoryID']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserCategory');
    }

}
