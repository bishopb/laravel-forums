<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGDNUserAuthenticationProviderTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GDN_UserAuthenticationProvider', function(Blueprint $table)
        {
            $table->string('AuthenticationKey', 64)->primary();
            $table->string('AuthenticationSchemeAlias', 32);
            $table->string('Name', 50)->nullable();
            $table->string('URL')->nullable();
            $table->text('AssociationSecret')->nullable();
            $table->string('AssociationHashMethod', 20)->nullable();
            $table->string('AuthenticateUrl')->nullable();
            $table->string('RegisterUrl')->nullable();
            $table->string('SignInUrl')->nullable();
            $table->string('SignOutUrl')->nullable();
            $table->string('PasswordUrl')->nullable();
            $table->string('ProfileUrl')->nullable();
            $table->text('Attributes')->nullable();
            $table->boolean('Active')->default(1);
            $table->boolean('IsDefault')->default(0);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('GDN_UserAuthenticationProvider');
    }

}
