<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNCategoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Category', function(Blueprint $table)
        {
            $table->integer('CategoryID', true);
            $table->integer('ParentCategoryID')->nullable();
            $table->integer('TreeLeft')->nullable();
            $table->integer('TreeRight')->nullable();
            $table->integer('Depth')->nullable();
            $table->integer('CountDiscussions')->default(0);
            $table->integer('CountComments')->default(0);
            $table->dateTime('DateMarkedRead')->nullable();
            $table->boolean('AllowDiscussions')->default(1);
            $table->boolean('Archived')->default(0);
            $table->string('Name', 255);
            $table->string('UrlCode', 255)->nullable();
            $table->string('Description', 500)->nullable();
            $table->integer('Sort')->nullable();
            $table->string('CssClass', 50)->nullable();
            $table->string('Photo', 255)->nullable();
            $table->integer('PermissionCategoryID')->default(-1);
            $table->integer('PointsCategoryID')->default(0);
            $table->boolean('HideAllDiscussions')->default(0);
            $table->enum('DisplayAs', array('Categories','Discussions','Default'))->default('Default');
            $table->integer('InsertUserID')->index('FK_Category_InsertUserID');
            $table->integer('UpdateUserID')->nullable();
            $table->dateTime('DateInserted');
            $table->dateTime('DateUpdated');
            $table->integer('LastCommentID')->nullable();
            $table->integer('LastDiscussionID')->nullable();
            $table->dateTime('LastDateInserted')->nullable();
            $table->string('AllowedDiscussionTypes', 255)->nullable();
            $table->string('DefaultDiscussionType', 10)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Category');
    }

}
