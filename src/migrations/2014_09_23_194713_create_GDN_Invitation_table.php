<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNInvitationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Invitation', function(Blueprint $table)
        {
            $table->integer('InvitationID', true);
            $table->string('Email', 200)->index('IX_Invitation_Email');
            $table->string('Name', 50)->nullable();
            $table->text('RoleIDs')->nullable();
            $table->string('Code', 50)->unique('UX_Invitation');
            $table->integer('InsertUserID')->nullable();
            $table->dateTime('DateInserted');
            $table->integer('AcceptedUserID')->nullable();
            $table->dateTime('DateExpires')->nullable();
            $table->index(['InsertUserID','DateInserted'], 'IX_Invitation_userdate');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Invitation');
    }

}
