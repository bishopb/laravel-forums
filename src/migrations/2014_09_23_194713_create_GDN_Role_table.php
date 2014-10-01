<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNRoleTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Role', function(Blueprint $table)
        {
            $table->integer('RoleID', true);
            $table->string('Name', 100);
            $table->string('Description', 500)->nullable();
            $table->integer('Sort')->nullable();
            $table->boolean('Deletable')->default(1);
            $table->boolean('CanSession')->default(1);
            $table->boolean('PersonalInfo')->default(0);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Role');
    }

}
