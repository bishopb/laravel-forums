<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNActivityTypeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_ActivityType', function(Blueprint $table)
        {
            $table->integer('ActivityTypeID', true);
            $table->string('Name', 20);
            $table->boolean('AllowComments')->default(0);
            $table->boolean('ShowIcon')->default(0);
            $table->string('ProfileHeadline', 255)->nullable();
            $table->string('FullHeadline', 255)->nullable();
            $table->string('RouteCode', 255)->nullable();
            $table->boolean('Notify')->default(0);
            $table->boolean('Public')->default(1);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_ActivityType');
    }

}
