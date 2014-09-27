<?php

namespace BishopB\Forum;

/**
 * Our own PluginManager, which will be injected into Vanilla for its use.
 */
class GardenPluginManager extends \Gdn_PluginManager
{
    /**
     * We want to re-publish the events
     */
    public function CallEventHandlers(
        $Sender, $EventClassName, $EventName, $EventHandlerType = 'Handler', $Options = []
    )
    {
        // re-publish
        \Event::fire('forum.event', [
            'Sender'           => $Sender,
            'EventClassName'   => $EventClassName,
            'EventName'        => $EventName,
            'EventHandlerType' => $EventHandlerType,
            'Options'          => $Options,
        ]);

        // log if we want to
        if (\Config::get('forum::package.trace-include-events', false)) {
            Trace(['EventClassName' => $EventClassName, 'EventName' => $EventName]);
        }

        // defer
        return parent::CallEventHandlers(
            $Sender, $EventClassName, $EventName, $EventHandlerType, $Options
        );
    }
}
