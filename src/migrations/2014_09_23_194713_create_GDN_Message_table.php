<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNMessageTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_Message', function(Blueprint $table)
        {
            $table->integer('MessageID', true);
            $table->text('Content');
            $table->string('Format', 20)->nullable();
            $table->boolean('AllowDismiss')->default(1);
            $table->boolean('Enabled')->default(1);
            $table->string('Application', 255)->nullable();
            $table->string('Controller', 255)->nullable();
            $table->string('Method', 255)->nullable();
            $table->integer('CategoryID')->nullable();
            $table->boolean('IncludeSubcategories')->default(0);
            $table->string('AssetTarget', 20)->nullable();
            $table->string('CssClass', 20)->nullable();
            $table->integer('Sort')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_Message');
    }

}
