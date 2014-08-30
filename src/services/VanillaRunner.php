<?php

namespace BishopB\Vfl;

/**
 * Provides a mechanism to run bootstrapped Vanilla.
 */
class VanillaRunner
{
    /**
     * Emulate a call to index.php?p=$vanilla_module_path
     * Much of this ripped out of Vanilla's index.php
     */
    public static function view($path_to_vanilla, $vanilla_module_path)
    {
        // vanilla doesn't pass E_STRICT
        error_reporting(
            E_ERROR|E_PARSE|E_CORE_ERROR|
            E_COMPILE_ERROR|E_USER_ERROR|E_RECOVERABLE_ERROR
        );

        // Define the constants we need to get going.
        define('APPLICATION', 'Vanilla');
        define('APPLICATION_VERSION', '2.2.16');
        define('DS', '/');
        define('PATH_ROOT', $path_to_vanilla);

        // Include the bootstrap to configure the framework.
        require_once(PATH_ROOT.'/bootstrap.php');

        // Create and configure the dispatcher.
        $_REQUEST['p'] = $vanilla_module_path;
        $Dispatcher = \Gdn::Dispatcher();

        $EnabledApplications = \Gdn::ApplicationManager()->EnabledApplicationFolders();
        $Dispatcher->EnabledApplicationFolders($EnabledApplications);
        $Dispatcher->PassProperty('EnabledApplications', $EnabledApplications);

        // Process the request.
        $Dispatcher->Start();
        $Dispatcher->Dispatch();
    }
}
