<?php

namespace BishopB\Forum;

use Illuminate\Http\Request;
use Illuminate\Config\Repository as Config;

/**
 * Dispatch to the Vanilla views.
 *
 * This class sets up the environment so that Vanilla can run seamlessly.
 */
class PassthruController extends \Controller
{
    public function __construct(Request $request, UserMapperInterface $mapper)
    {
        $this->request = $request;
        $this->mapper  = $mapper;
    }

    public function index()
    {
        // get the segments after our route prefix (/foo/bar) and feed into vanilla
        $segments = $this->request->segments();
        if (forum_get_route_prefix() === head($segments)) {
            array_shift($segments);
        }

        // use a default if needed
        if (0 === count($segments)) {
            $segments = [ 'discussions' ];
        }

        // run vanilla with the path and user we want
        $runner = new VanillaRunner();
        $runner->login($this->mapper->current());
        return $runner->view($segments);
    }
}
