<?php

namespace BishopB\Forum;

/**
 * Provides a mechanism to run Vanilla inside of Laravel.
 */
class VanillaRunner
{
    use VanillaHelperTrait;

    /**
     * Log the given user in to this session
     */
    public function login(User $user)
    {
        $this->user = $user;
    }

    /**
     * Emulate a call to index.php?p=$vanilla_module_path
     * Much of this ripped out of Vanilla's index.php
     */
    public function view($segments)
    {
        // if the segments point to an extant file, serve it up directly
        $implode = implode('/', $segments);
        $targets = [
            dirname(__DIR__) . '/views/' . $implode,    // a theme file?
            $this->get_vanilla_path() . '/' . $implode, // a Vanilla resource?
        ];
        foreach ($targets as $target) {
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
                return \Response::
                    make(\File::get($target))->
                    header('Content-Type', $ct)
                ;
            }
        }

        // otherwise, dispatch into vanilla
        $user = $this->user;

        $bootstrap = new VanillaBootstrap();
        $bootstrap->call(function () use ($user, $segments) {
            // Create the session and stuff the user in
            \Gdn::Authenticator()->SetIdentity($user->getKey(), false /* no persist */);
            \Gdn::Session()->Start(false /* use set identity */, false /* no persist */);
            \Gdn::Session()->SetPreference('Authenticator', 'Gdn_Authenticator');

            // Create and configure the dispatcher.
            $Dispatcher = \Gdn::Dispatcher();

            $EnabledApplications = \Gdn::ApplicationManager()->EnabledApplicationFolders();
            $Dispatcher->EnabledApplicationFolders($EnabledApplications);
            $Dispatcher->PassProperty('EnabledApplications', $EnabledApplications);

            // Process the request.
            $Dispatcher->Start();
            $Dispatcher->Dispatch(implode('/', $segments));
        });
    }
}
