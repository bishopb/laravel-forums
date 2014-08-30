<?php

namespace BishopB\Vfl;

class VflServiceProvider extends \Illuminate\Support\ServiceProvider
{
	/**
	 * Routing is about to happen, register our route oriented needs.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('bishopb/vanilla-for-laravel', 'vfl', __DIR__);

		require_once __DIR__ . '/boot/helpers.php';
		require_once __DIR__ . '/boot/routes.php';

        if (! is_dir($p = \Config::get('vfl::paths.vanilla'))) {
            throw new VanillaForumsNotFoundException($p);
        }
	}

	/**
	 * Register the service provider. Keep it fast.
	 *
	 * @return void
	 */
	public function register()
	{
	}

	/**
	 * We have views and configuration: can't defer.
	 *
	 * @var bool
	 */
	protected $defer = false;

}
