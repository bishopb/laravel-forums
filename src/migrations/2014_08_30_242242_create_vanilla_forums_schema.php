<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVanillaForumsSchema extends Migration
{
	public function up()
	{
        // if mysql grammar
        include(PATH_APPLICATIONS . DS . 'dashboard' . DS . 'settings' . DS . 'structure.php');
	}

	public function down()
	{
        // for all tables like connector prefix dot GDN_, drop
        // or maybe global $DROP = true and include the structure?
	}
}
