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
        $grammar = Schema::getConnection()->getSchemaGrammar();

        Schema::create('GDN_Discussion', function (Blueprint $table) use ($grammar)
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

            if ($grammar instanceof \Illuminate\Database\Schema\Grammars\MySqlGrammar) {
                $table->engine = 'MyISAM';
            }
        });

        if ($grammar instanceof \Illuminate\Database\Schema\Grammars\MySqlGrammar) {
            DB::statement('ALTER TABLE `GDN_Discussion` ADD FULLTEXT search(Name,Body)');
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $grammar = Schema::getConnection()->getSchemaGrammar();
        if ($grammar instanceof \Illuminate\Database\Schema\Grammars\MySqlGrammar) {
            Schema::table('GDN_Discussion', function($table) {
                $table->dropIndex('search');
            });
        }

        Schema::drop('GDN_Discussion');
    }

}
