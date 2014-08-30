<?php

namespace BishopB\Vfl;

/**
 * Generic stuff we need/do as we interact with Vanilla
 */
abstract class AbstractVanillaService
{
    /**
     * Get the path to Vanilla Forums software
     */
    public function getVanillaPath()
    {
        return \Config::get('vfl::paths.vanilla');
    }

    /**
     * Set a value into the Vanilla configuration.
     */
    public function set($key, $value)
    {
        \Gdn::Config()->Set($key, $value, true /*overwrite*/, false /*dont persist*/);
    }

    /**
     * Get a value from the Vanilla configuration.
     */
    public function get($key)
    {
        return \Gdn::Config()->Get($key);
    }
}
