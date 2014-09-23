<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNPermissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('GDN_Permission', function(Blueprint $table)
		{
			$table->integer('PermissionID', true);
			$table->integer('RoleID')->default(0)->index('FK_Permission_RoleID');
			$table->string('JunctionTable', 100)->nullable();
			$table->string('JunctionColumn', 100)->nullable();
			$table->integer('JunctionID')->nullable();
			$table->boolean('Garden.Email')->default(0);
			$table->boolean('Garden.Settings')->default(0);
			$table->boolean('Garden.Messages')->default(0);
			$table->boolean('Garden.SignIn')->default(0);
			$table->boolean('Garden.Users')->default(0);
			$table->boolean('Garden.Activity')->default(0);
			$table->boolean('Garden.Profiles')->default(0);
			$table->boolean('Garden.Curation')->default(0);
			$table->boolean('Garden.Moderation')->default(0);
			$table->boolean('Garden.PersonalInfo')->default(0);
			$table->boolean('Garden.AdvancedNotifications')->default(0);
			$table->boolean('Conversations.Moderation')->default(0);
			$table->boolean('Conversations.Conversations')->default(0);
			$table->boolean('Vanilla.Approval')->default(0);
			$table->boolean('Vanilla.Comments')->default(0);
			$table->boolean('Vanilla.Discussions')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('GDN_Permission');
	}

}
