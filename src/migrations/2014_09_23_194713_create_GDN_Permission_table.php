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
            // Vanilla may add these on the fly:
            // got to love dynamic schema!
            $table->boolean(DB::raw('`Garden.Email.View`'))->default(0);
            $table->boolean(DB::raw('`Garden.Settings.Manage`'))->default(0);
            $table->boolean(DB::raw('`Garden.Settings.View`'))->default(0);
            $table->boolean(DB::raw('`Garden.Messages.Manage`'))->default(0);
            $table->boolean(DB::raw('`Garden.SignIn.Allow`'))->default(0);
            $table->boolean(DB::raw('`Garden.Users.Add`'))->default(0);
            $table->boolean(DB::raw('`Garden.Users.Edit`'))->default(0);
            $table->boolean(DB::raw('`Garden.Users.Delete`'))->default(0);
            $table->boolean(DB::raw('`Garden.Users.Approve`'))->default(0);
            $table->boolean(DB::raw('`Garden.Activity.Delete`'))->default(0);
            $table->boolean(DB::raw('`Garden.Activity.View`'))->default(0);
            $table->boolean(DB::raw('`Garden.Profiles.View`'))->default(0);
            $table->boolean(DB::raw('`Garden.Profiles.Edit`'))->default(0);
            $table->boolean(DB::raw('`Garden.Curation.Manage`'))->default(0);
            $table->boolean(DB::raw('`Garden.Moderation.Manage`'))->default(0);
            $table->boolean(DB::raw('`Garden.PersonalInfo.View`'))->default(0);
            $table->boolean(DB::raw('`Garden.AdvancedNotifications.Allow`'))->default(0);
            $table->boolean(DB::raw('`Conversations.Moderation.Manage`'))->default(0);
            $table->boolean(DB::raw('`Conversations.Conversations.Add`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Approval.Require`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Comments.Me`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Discussions.View`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Discussions.Add`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Discussions.Edit`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Discussions.Announce`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Discussions.Sink`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Discussions.Close`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Discussions.Delete`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Comments.Add`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Comments.Edit`'))->default(0);
            $table->boolean(DB::raw('`Vanilla.Comments.Delete`'))->default(0);
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
