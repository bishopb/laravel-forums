<?php

namespace BishopB\Vfl;

/**
 * Provides a mechanism to run Vanilla inside of Laravel.
 */
class VanillaRunner extends AbstractVanillaService
{
    /**
     * Are we inside of ::view()?
     */
    public function isRunning()
    {
        return defined('APPLICATION_VERSION');
    }

    /**
     * Emulate a call to index.php?p=$vanilla_module_path
     * Much of this ripped out of Vanilla's index.php
     */
    public static function view($path_to_vanilla, $segments)
    {
        // Create and configure the dispatcher.
        $Dispatcher = \Gdn::Dispatcher();

        $EnabledApplications = \Gdn::ApplicationManager()->EnabledApplicationFolders();
        $Dispatcher->EnabledApplicationFolders($EnabledApplications);
        $Dispatcher->PassProperty('EnabledApplications', $EnabledApplications);

        // Process the request.
        $Dispatcher->Start();
        $Dispatcher->Dispatch(implode('/', $segments));

        /*
        // doesn't work either
        $view = sprintf(
            '%s/applications/%s/views/%s.php',
            $path_to_vanilla,
            $segments[0],
            implode('/', array_slice($segments, 1))
        );
        if (is_readable($view)) {
            @include $view;
        } else {
            throw new VanillaForumsContentNotFound(implode('/', $segments));
        }
        */
    }
}
