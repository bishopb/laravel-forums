<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserPointsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserPoints', function(Blueprint $table)
        {
            $table->enum('SlotType', array('d','w','m','y','a'));
            $table->dateTime('TimeSlot');
            $table->string('Source', 10)->default('Total');
            $table->integer('CategoryID')->default(0);
            $table->integer('UserID');
            $table->integer('Points')->default(0);
            $table->primary(['SlotType','TimeSlot','Source','CategoryID','UserID'], 'composite');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserPoints');
    }

}
