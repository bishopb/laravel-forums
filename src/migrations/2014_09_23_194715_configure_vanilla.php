<?php

use Illuminate\Database\Migrations\Migration;

class ConfigureVanilla extends Migration
{
	public function up()
	{
        $setup = new \BishopB\Vfl\VanillaSetup();
        $setup->install();
	}

	public function down()
	{
        $setup = new \BishopB\Vfl\VanillaSetup();
        $setup->uninstall();
	}
}
