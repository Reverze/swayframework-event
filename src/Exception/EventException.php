<?php

namespace Sway\Component\Event\Exception;

class EventException extends \Exception
{
    /**
     * Throws an exception when event class's name is not suffixed by 'Event'
     * @param string $className
     * @return \Sway\Component\Event\Exception\EventException
     */
    public static function invalidEventClassName(string $className) : EventException
    {
        return (new EventException(sprintf("Event's class name must be suffixed by 'Event'. Class: '%s'", $className)));
    }
    
    /**
     * Throws an exception when event class is not exists
     * @param string $className
     * @return \Sway\Component\Event\Exception\EventException
     */
    public static function eventClassNotExists(string $className) : EventException
    {
        return (new EventException(sprintf("Class '%s' not found", $className)));
    }
    
}


?>

