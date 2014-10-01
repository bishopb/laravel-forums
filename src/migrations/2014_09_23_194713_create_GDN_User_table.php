<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_User', function(Blueprint $table)
        {
            $table->integer('UserID', true);
            $table->string('Name', 50)->index('FK_User_Name');
            $table->binary('Password', 100);
            $table->string('HashMethod', 10)->nullable();
            $table->string('Photo', 255)->nullable();
            $table->string('Title', 100)->nullable();
            $table->string('Location', 100)->nullable();
            $table->text('About')->nullable();
            $table->string('Email', 200)->index('IX_User_Email');
            $table->boolean('ShowEmail')->default(0);
            $table->enum('Gender', array('u','m','f'))->default('u');
            $table->integer('CountVisits')->default(0);
            $table->integer('CountInvitations')->default(0);
            $table->integer('CountNotifications')->nullable();
            $table->integer('InviteUserID')->nullable();
            $table->text('DiscoveryText')->nullable();
            $table->text('Preferences')->nullable();
            $table->text('Permissions')->nullable();
            $table->text('Attributes')->nullable();
            $table->dateTime('DateSetInvitations')->nullable();
            $table->dateTime('DateOfBirth')->nullable();
            $table->dateTime('DateFirstVisit')->nullable();
            $table->dateTime('DateLastActive')->nullable()->index('IX_User_DateLastActive');
            $table->string('LastIPAddress', 15)->nullable();
            $table->string('AllIPAddresses', 100)->nullable();
            $table->dateTime('DateInserted')->index('IX_User_DateInserted');
            $table->string('InsertIPAddress', 15)->nullable();
            $table->dateTime('DateUpdated')->nullable();
            $table->string('UpdateIPAddress', 15)->nullable();
            $table->integer('HourOffset')->default(0);
            $table->float('Score', 10, 0)->nullable();
            $table->boolean('Admin')->default(0);
            $table->boolean('Confirmed')->default(1);
            $table->boolean('Verified')->default(0);
            $table->boolean('Banned')->default(0);
            $table->boolean('Deleted')->default(0);
            $table->integer('Points')->default(0);
            $table->integer('CountUnreadConversations')->nullable();
            $table->integer('CountDiscussions')->nullable();
            $table->integer('CountUnreadDiscussions')->nullable();
            $table->integer('CountComments')->nullable();
            $table->integer('CountDrafts')->nullable();
            $table->integer('CountBookmarks')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_User');
    }

}
