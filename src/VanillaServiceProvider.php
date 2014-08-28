<?php

namespace BishopB\VanillaForLaravel;

class VanillaServiceProvider extends \Illuminate\Support\ServiceProvider
{
	/**
	 * Defer loading until needed.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the package events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('bishopb/vanilla-for-laravel', 'vanilla');

		require_once __DIR__ . '/helpers.php';
		require_once __DIR__ . '/routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}
}
