<?php

namespace BishopB\Vfl;

/**
 * Generic stuff we need/do as we interact with Vanilla
 */
trait VanillaHelperTrait
{
    /**
     * Get the path to Vanilla Forums software
     */
    public static function get_vanilla_path()
    {
        return \Config::get('vfl::paths.vanilla');
    }

    /**
     * Set a value into the Vanilla run-time configuration
     */
    public static function set($key, $value)
    {
        \Gdn::Config()->Set($key, $value, true /*overwrite*/, false /*dont persist*/);
    }

    /**
     * Get a value from the Vanilla run-time configuration
     */
    public static function get($key)
    {
        return \Gdn::Config()->Get($key);
    }

    /**
     * Get the version of Vanilla installed.
     * TODO Pull from Vanilla's index.php
     */
    public static function get_vanilla_version()
    {
        return '2.2.16.1';
    }
}
