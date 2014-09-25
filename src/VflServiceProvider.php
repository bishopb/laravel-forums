<?php

namespace BishopB\Vfl;

class VflServiceProvider extends \Illuminate\Support\ServiceProvider
{
	/**
	 * Routing is about to happen, define things we'll need for routing.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('bishopb/vanilla-for-laravel', 'vfl', __DIR__);

		require_once __DIR__ . '/boot/helpers.php';
		require_once __DIR__ . '/boot/routes.php';
	}

	/**
	 * Register the service provider. Keep it fast.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->register(
            'Felixkiss\UniqueWithValidator\UniqueWithValidatorServiceProvider'
        );

        $this->app['vfl::commands.migrate'] = $this->app->share(function ($app) {
            return new VanillaMigrate();
        });
        $this->app['vfl::commands.connect'] = $this->app->share(function ($app) {
            return new VanillaConnect();
        });

        $this->commands('vfl::commands.migrate', 'vfl::commands.connect');
	}

	/**
	 * We have views and configuration: can't defer.
	 *
	 * @var bool
	 */
	protected $defer = false;
}
