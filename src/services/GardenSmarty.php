<?php

namespace BishopB\Forum;

/**
 * Our own Smarty template.
 */
class GardenSmarty extends \Gdn_Smarty
{
    /**
     * Hook into the method by which smarty is called.
     */
    public function Init($Path, $Controller)
    {
        parent::Init($Path, $Controller);

        $smarty = $this->Smarty();

        // stuff all the facades into Smarty
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        foreach ($loader->getAliases() as $alias => $class) {
            $object = $this->resolve($class);
            $smarty->assign($alias, $object);
        }
    }

    /**
     * Yanked from davejamesmiller/laravel-aliases
     */
    protected function resolve($class)
    {
        if ($this->isFacade($class)) {
            if ($accessor = $this->getFacadeAccessor($class)) {
                return \App::make($accessor);
            } else {
                return $class::getFacadeRoot();
            }
        }

        return null;
    }

    protected function isFacade($class)
    {
        return get_parent_class($class) == 'Illuminate\Support\Facades\Facade';
    }

    protected function getFacadeAccessor($class)
    {
        // HACK!!
        $method = new \ReflectionMethod($class, 'getFacadeAccessor');
        $method->setAccessible(true);
        $accessor = $method->invoke(null);

        // Some facades return an object not a name, e.g. Illuminate\Support\Facades\Blade
        return is_string($accessor) ? $accessor : null;
    }

}
