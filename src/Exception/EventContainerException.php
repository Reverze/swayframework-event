<?php

namespace Sway\Component\Event\Exception;

class EventContainerException extends \Exception
{
    /**
     * Throws an exception when event not found by name
     * @param string $eventName
     * @return \Sway\Component\Event\Exception\EventContainerException
     */
    public static function eventNotFound(string $eventName) : EventContainerException
    {
        return (new EventContainerException(sprintf("Event not found by name: '%s'", $eventName)));
    }
    
    /**
     * Throws an exception when ...
     * @param string $triggerDefinition
     * @return \Sway\Component\Event\Exception\EventContainerException
     */
    public static function emptyComponentTriggerDefinition(string $triggerDefinition) : EventContainerException
    {
        return (new EventContainerException(sprintf("Component trigger definition is empty")));
    }
    
    public static function componentTriggerMethodNotDefined(string $triggerDefinition) : EventContainerException
    {
        return (new EventContainerException(sprintf("Method not defined")));
    }
    
    /**
     * Throws an exception when component method's name is invalid
     * @param string $component
     * @param string $methodName
     * @return \Sway\Component\Event\Exception\EventContainerException
     */
    public static function invalidComponentMethodName(string $component, string $methodName) : EventContainerException
    {
        return (new EventContainerException(sprintf("Method's name (%s) is invalid for component %s", $methodName, $component)));
    }
}

?>
