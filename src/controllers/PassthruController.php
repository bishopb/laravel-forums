<?php

namespace BishopB\Vfl;

use Illuminate\Http\Request;
use Illuminate\Config\Repository as Config;

/**
 * Dispatch to the Vanilla views.
 *
 * This class sets up the environment so that Vanilla can run seamlessly.
 */
class PassthruController extends \Controller
{
    public function __construct(Request $request, Config $config)
    {
        $this->request = $request;
        $this->config  = $config;

        $this->vanilla_path = $this->config->get('vfl::paths.vanilla');
    }

    public function index()
    {
        $user = User::createWithRoles(
            [ 'Name' => 'Whatever', 'Email' => 'x@example.com', ],
            [ RoleRepository::member(), RoleRepository::moderator() ]
        );
        dd($user, $user->roles);

        // get the segments after our route prefix (/foo/bar) and feed into vanilla
        $segments = $this->request->segments();
        if (vfl_get_route_prefix() === head($segments)) {
            array_shift($segments);
        }

        // use a default if needed
        if (0 === count($segments)) {
            $segments = [ 'discussions' ];
        }

        // run vanilla with the path we got
        $runner = new VanillaRunner();
        $runner->view($segments);
    }
}
