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

        // Laravel is going to define this function with a signature
        // incompatible with Vanilla.  So we define ourselves one that works
        // with both.
        //
        // Taken from <vanilla>/library/core/functions.general.php
        // Taken from <laravel>/src/Illuminate/Support/helpers.php
        function url($path = null, $parameters = [], $secure = null)
        {
                return app('url')->to(
                    vfl_get_route_prefix() . $path,
                    (is_array($parameters) ? $parameters : []),
                    $secure
                );
        }
	}

	/**
	 * We have views and configuration: can't defer.
	 *
	 * @var bool
	 */
	protected $defer = false;
}
