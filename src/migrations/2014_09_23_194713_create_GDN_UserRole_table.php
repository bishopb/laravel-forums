<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserRoleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserRole', function(Blueprint $table)
        {
            $table->integer('UserID');
            $table->integer('RoleID')->index('IX_UserRole_RoleID');
            $table->primary(['UserID','RoleID']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserRole');
    }

}
