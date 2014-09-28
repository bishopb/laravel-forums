<?php

namespace BishopB\Forum;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Run the migrations. Just a convenience method.
 */
class VanillaMigrate extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'forum:migrate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Apply Vanilla database migrations.';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $options = [];
        foreach ($this->input->getOptions() as $option => $value) {
            if (! empty($value)) {
                $options['--' . $option] = $value;
            }
        }

        $options['--package'] = 'bishopb/laravel-forums';

        $this->call('migrate', $options);
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
        $o = InputOption::VALUE_OPTIONAL;
        $n = InputOption::VALUE_NONE;
        return [
            [ 'database', null, $o, 'The database connection to use.' ],
            [ 'force',    null, $n, 'Force the operation to run when in production.' ],
            [ 'pretend',  null, $n, 'Dump the SQL queries that would be run.' ],
        ];
	}
}
