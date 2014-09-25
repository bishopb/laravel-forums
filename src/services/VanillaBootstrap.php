<?php

namespace BishopB\Vfl;

/**
 * Do what's necessary to get Vanilla's framework running.
 */
class VanillaBootstrap extends AbstractVanillaService
{
    /**
     * Boot up Vanilla.
     * 
     * Much of this ripped out of Vanilla's index.php
     */
    public function __construct()
    {
        // vanilla doesn't pass E_STRICT
        error_reporting(
            E_ERROR|E_PARSE|E_CORE_ERROR|
            E_COMPILE_ERROR|E_USER_ERROR|E_RECOVERABLE_ERROR
        );

        // Define the constants we need to get going.
        define('APPLICATION',         'Vanilla');
        define('APPLICATION_VERSION', $this->get_vanilla_version());
        define('DS',                  '/');
        define('PATH_ROOT',           $this->get_vanilla_path());

        // Vanilla and Laravel share some common global functions, like `url`
        // and `asset`.  Laravel's defintion won, so now we need to override
        // these functions to be compatible with Vanilla.
        \App::bind('url', function()
        {
            return new UrlGenerator(
                \App::make('router')->getRoutes(),
                \App::make('request')
            );
        });

        // alright, boot it up
        require_once(PATH_ROOT . '/bootstrap.php');
    }
}
