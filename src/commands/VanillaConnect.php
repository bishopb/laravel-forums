<?php

namespace BishopB\Forum;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Do what's necessary to connect Vanilla to Laravel.
 */
class VanillaConnect extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'forum:connect';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Connect Vanilla to Laravel. Do this each time Vanilla updates.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $setup = new VanillaSetup();
        $setup->install();
        $this->info(
            'Vanilla now connected to Laravel. Try it out at ' .
            \URL::to(forum_get_route_prefix())
        );
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}
}
