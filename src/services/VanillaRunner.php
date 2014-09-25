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
    public function view($segments)
    {
        // if the segments point to an extant file, serve it up directly
        $target = $this->get_vanilla_path() . '/' . implode('/', $segments);
        if (is_readable($target)) {
            // TODO: Replace this with a dead simple library
            // TODO: googling "github php mimetype to file extension returns heavy projects
            // @see http://stackoverflow.com/questions/19681854
            switch (pathinfo($target, PATHINFO_EXTENSION)) {
                case 'js' : $ct = 'text/javascript'; break;
                case 'css': $ct = 'text/css'; break;
                case 'png': $ct = 'image/png'; break;
                case 'jpg': $ct = 'image/jpg'; break;
                case 'gif': $ct = 'image/gif'; break;
                default:    $ct = 'text/plain'; break;
            }
            header("Content-Type: $ct");
            readfile($target);
            return;
        }

        // otherwise, dispatch into vanilla
        new VanillaBootstrap();

        // Create and configure the dispatcher.
        $Dispatcher = \Gdn::Dispatcher();

        $EnabledApplications = \Gdn::ApplicationManager()->EnabledApplicationFolders();
        $Dispatcher->EnabledApplicationFolders($EnabledApplications);
        $Dispatcher->PassProperty('EnabledApplications', $EnabledApplications);

        // Process the request.
        $Dispatcher->Start();
        $Dispatcher->Dispatch(implode('/', $segments));
    }
}
