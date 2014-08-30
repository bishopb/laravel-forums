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
        // vanilla needs to be installed
        VanillaAdapter::install($this->vanilla_path);

        // get the segments (/foo/bar) and feed into the "p" variable vanilla wants
        $segments = $this->request->segments();
        if (vfl_get_route_prefix() === head($segments)) {
            array_shift($segments);
        }

        // run vanilla with the path we got
        VanillaRunner::view($this->vanilla_path, $segments);
    }
}
