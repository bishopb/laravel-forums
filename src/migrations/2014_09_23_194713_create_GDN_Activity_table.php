<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNActivityTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Activity', function(Blueprint $table)
        {
            $table->integer('ActivityID', true);
            $table->integer('ActivityTypeID');
            $table->integer('NotifyUserID')->default(0);
            $table->integer('ActivityUserID')->nullable();
            $table->integer('RegardingUserID')->nullable();
            $table->string('Photo', 255)->nullable();
            $table->string('HeadlineFormat', 255)->nullable();
            $table->text('Story')->nullable();
            $table->string('Format', 10)->nullable();
            $table->string('Route', 255)->nullable();
            $table->string('RecordType', 20)->nullable();
            $table->integer('RecordID')->nullable();
            $table->integer('InsertUserID')->nullable()->index('FK_Activity_InsertUserID');
            $table->dateTime('DateInserted');
            $table->string('InsertIPAddress', 15)->nullable();
            $table->dateTime('DateUpdated')->nullable()->index('IX_Activity_DateUpdated');
            $table->boolean('Notified')->default(0);
            $table->boolean('Emailed')->default(0);
            $table->text('Data')->nullable();
            $table->index(['NotifyUserID','Notified'], 'IX_Activity_Notify');
            $table->index(['NotifyUserID','DateUpdated'], 'IX_Activity_Recent');
            $table->index(['NotifyUserID','ActivityUserID','DateUpdated'], 'IX_Activity_Feed');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Activity');
    }

}
