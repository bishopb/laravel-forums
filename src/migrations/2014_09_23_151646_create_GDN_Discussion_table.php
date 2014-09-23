<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNDiscussionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('GDN_Discussion', function(Blueprint $table)
		{
			$table->integer('DiscussionID', true);
			$table->string('Type', 10)->nullable()->index('IX_Discussion_Type');
			$table->string('ForeignID', 32)->nullable()->index('IX_Discussion_ForeignID');
			$table->integer('CategoryID');
			$table->integer('InsertUserID')->index('FK_Discussion_InsertUserID');
			$table->integer('UpdateUserID')->nullable();
			$table->integer('FirstCommentID')->nullable();
			$table->integer('LastCommentID')->nullable();
			$table->string('Name', 100);
			$table->text('Body');
			$table->string('Format', 20)->nullable();
			$table->text('Tags')->nullable();
			$table->integer('CountComments')->default(0);
			$table->integer('CountBookmarks')->nullable();
			$table->integer('CountViews')->default(1);
			$table->boolean('Closed')->default(0);
			$table->boolean('Announce')->default(0);
			$table->boolean('Sink')->default(0);
			$table->dateTime('DateInserted')->index('IX_Discussion_DateInserted');
			$table->dateTime('DateUpdated')->nullable();
			$table->string('InsertIPAddress', 15)->nullable();
			$table->string('UpdateIPAddress', 15)->nullable();
			$table->dateTime('DateLastComment')->nullable()->index('IX_Discussion_DateLastComment');
			$table->integer('LastCommentUserID')->nullable();
			$table->float('Score', 10, 0)->nullable();
			$table->text('Attributes')->nullable();
			$table->integer('RegardingID')->nullable()->index('IX_Discussion_RegardingID');
			$table->index(['CategoryID','DateLastComment'], 'IX_Discussion_CategoryPages');
			$table->index(['CategoryID','DateInserted'], 'IX_Discussion_CategoryInserted');
			$table->index(['Name','Body'], 'TX_Discussion');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('GDN_Discussion');
	}

}
