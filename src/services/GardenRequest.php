<?php

namespace BishopB\Forum;

/**
 * Our own Request handler, which will be injected into Vanilla for its use.
 */
class GardenRequest extends \Gdn_Request
{
    /**
     * We specifically always want our web root inside our route.
     */
    public function WebRoot($WebRoot = NULL)
    {
        return forum_get_route_prefix();
    }

    /**
     * Some machinery to play nice with Vanilla's Garden Framework IOC.
     */
    public static function Create()
    {
        return new GardenRequest();
    }

    private function __construct()
    {
        $this->Reset();
    }
}
