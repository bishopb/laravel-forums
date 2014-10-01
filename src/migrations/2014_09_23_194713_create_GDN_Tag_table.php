<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNTagTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Tag', function(Blueprint $table)
        {
            $table->integer('TagID', true);
            $table->string('Name', 255);
            $table->string('FullName', 255)->index('IX_Tag_FullName');
            $table->string('Type', 20)->default('')->index('IX_Tag_Type');
            $table->integer('ParentTagID')->nullable()->index('FK_Tag_ParentTagID');
            $table->integer('InsertUserID')->nullable()->index('FK_Tag_InsertUserID');
            $table->dateTime('DateInserted');
            $table->integer('CategoryID')->default(-1);
            $table->integer('CountDiscussions')->default(0);
            $table->unique(['Name','CategoryID'], 'UX_Tag');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Tag');
    }

}
