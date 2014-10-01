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
        $grammar = Schema::getConnection()->getSchemaGrammar();

        Schema::create('GDN_Comment', function (Blueprint $table) use ($grammar)
        {
            $table->integer('CommentID', true);
            $table->integer('DiscussionID');
            $table->integer('InsertUserID')->nullable()->index('FK_Comment_InsertUserID');
            $table->integer('UpdateUserID')->nullable();
            $table->integer('DeleteUserID')->nullable();
            $table->text('Body');
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
            if ($grammar instanceof \Illuminate\Database\Schema\Grammars\MySqlGrammar) {
                $table->engine = 'MyISAM';
            }
        });

        if ($grammar instanceof \Illuminate\Database\Schema\Grammars\MySqlGrammar) {
            DB::statement('ALTER TABLE `GDN_Comment` ADD FULLTEXT search(Body)');
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
            Schema::table('GDN_Comment', function($table) {
                $table->dropIndex('search');
            });
        }
        Schema::drop('GDN_Comment');
    }

}
