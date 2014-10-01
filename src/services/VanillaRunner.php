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
        // if a static asset, return it outright
        $asset = $this->is_static_asset($segments);
        if ($asset) {
            return \Response::
                make(\File::get($asset))->
                header('Content-Type', $this->get_content_type($asset))
            ;
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

    /**
     * Determine if these segments refer to a static, on disk asset and, 
     * if so, return the path to it.
     *
     * @param array $segments
     * @return mixed
     */
    protected function is_static_asset(array $segments)
    {
        // enumerate the possible targets
        $implode = '/'. implode('/', $segments);
        $targets = [
            // a theme file published to the app?
            app_path() . '/views/packages/bishopb/laravel-forums' . $implode,

            // a theme file in this package?
            dirname(__DIR__) . '/views' . $implode,

            // a Vanilla resource?
            $this->get_vanilla_path() . $implode,

            // an upload?
            dirname(\Config::get('forum::paths.uploads')) . $implode,
        ];

        foreach ($targets as $target) {
            if (is_readable($target)) {
                return $target;
            }
        }
    }

    /**
     * Get the content type of the target.
     * TODO: Replace this with a dead simple library
     * TODO: googling "github php mimetype to file extension returns heavy projects
     * @see http://stackoverflow.com/questions/19681854
     */
    protected function get_content_type($target)
    {
        switch (pathinfo($target, PATHINFO_EXTENSION)) {
            case 'js' : return 'text/javascript';
            case 'css': return 'text/css';
            case 'png': return 'image/png';
            case 'jpg': return 'image/jpg';
            case 'gif': return 'image/gif';
            default:    return 'text/plain';
        }
    }
}
