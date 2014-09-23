<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNCommentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('GDN_Comment', function(Blueprint $table)
		{
			$table->integer('CommentID', true);
			$table->integer('DiscussionID');
			$table->integer('InsertUserID')->nullable()->index('FK_Comment_InsertUserID');
			$table->integer('UpdateUserID')->nullable();
			$table->integer('DeleteUserID')->nullable();
			$table->text('Body')->index('TX_Comment');
			$table->string('Format', 20)->nullable();
			$table->dateTime('DateInserted')->nullable()->index('IX_Comment_DateInserted');
			$table->dateTime('DateDeleted')->nullable();
			$table->dateTime('DateUpdated')->nullable();
			$table->string('InsertIPAddress', 15)->nullable();
			$table->string('UpdateIPAddress', 15)->nullable();
			$table->boolean('Flag')->default(0);
			$table->float('Score', 10, 0)->nullable();
			$table->text('Attributes')->nullable();
			$table->index(['DiscussionID','DateInserted'], 'IX_Comment_1');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('GDN_Comment');
	}

}
