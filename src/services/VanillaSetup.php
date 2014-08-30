<?php

namespace BishopB\Vfl;

/**
 * Perform the Vanilla setup tasks, just like someone did it manually.
 */
class VanillaSetup extends VanillaService
{
    public function setup($path)
    {
        // TODO install our bootstrap adapter
        $p = $path . '/conf/bootstrap.early.php';
        if (! file_exists($p)) {
            file_put_contents($p, '<?php return \BishopB\Vfl\VanillaAdapter::run();');
        }

        // TODO run the schema
        // include(PATH_APPLICATIONS . DS . 'dashboard' . DS . 'settings' . DS . 'structure.php');

        // tell Garden we're installed
        static::set('Garden.Installed', true);
    }
}
