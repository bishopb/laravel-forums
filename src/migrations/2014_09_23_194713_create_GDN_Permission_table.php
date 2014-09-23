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
			$table->boolean(DB::raw('`Garden.Email`'))->default(0);
			$table->boolean(DB::raw('`Garden.Settings`'))->default(0);
			$table->boolean(DB::raw('`Garden.Messages`'))->default(0);
			$table->boolean(DB::raw('`Garden.SignIn`'))->default(0);
			$table->boolean(DB::raw('`Garden.Users`'))->default(0);
			$table->boolean(DB::raw('`Garden.Activity`'))->default(0);
			$table->boolean(DB::raw('`Garden.Profiles`'))->default(0);
			$table->boolean(DB::raw('`Garden.Curation`'))->default(0);
			$table->boolean(DB::raw('`Garden.Moderation`'))->default(0);
			$table->boolean(DB::raw('`Garden.PersonalInfo`'))->default(0);
			$table->boolean(DB::raw('`Garden.AdvancedNotifications`'))->default(0);
			$table->boolean(DB::raw('`Conversations.Moderation`'))->default(0);
			$table->boolean(DB::raw('`Conversations.Conversations`'))->default(0);
			$table->boolean(DB::raw('`Vanilla.Approval`'))->default(0);
			$table->boolean(DB::raw('`Vanilla.Comments`'))->default(0);
			$table->boolean(DB::raw('`Vanilla.Discussions`'))->default(0);
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
