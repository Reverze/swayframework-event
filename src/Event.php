<?php

namespace Sway\Component\Event;

use Sway\Component\Dependency\DependencyInterface;
use Sway\Component\Text\Stringify;

abstract class Event extends DependencyInterface
{
    /**
     * Event's name
     * @var string
     */
    private $eventName = null;
    
    /**
     * Event's container
     * @var \Sway\Component\Event\EventContainer
     */
    private $eventContainer = null;
    
    /**
     * Array which contains event's listener
     * @var array
     */
    private $listeners = array();
    
    public function __construct()
    {
        $this->determineEventName();
    }
    
    /**
     * Determines event's name based on class's name
     * @throws \Sway\Component\Event\Exception\EventException
     */
    private function determineEventName()
    {
        /**
         * Reflection class
         */
        $classReflector = new \ReflectionClass($this);
        
        /**
         * Gets event's class name
         */
        $className = $classReflector->getName();
        
        
        /**
         * Checks if word 'Event' is suffix at class's name
         */
        if (!Stringify::isSuffixedBy('Event', $className)){
            throw Exception\EventException::invalidEventClassName($className);
        }
        
        $exploded = explode("\\", $className);
        /**
         * Gets event's name based on class's name
         */
        $eventName = Stringify::replace($exploded[sizeof($exploded) - 1], 'Event', '');
        
        $this->eventName = $eventName;
    }
    
    /**
     * Stores some dependecies
     */
    protected function dependencyController() 
    {
        /**
         * Gets event's container
         */
        $this->eventContainer = $this->getDependency('event');
    }
    
    /**
     * Gets event's name
     * @return string
     */
    public function getName() : string
    {
        return $this->eventName;
    }
    
    /**
     * Triggers event
     * @param \Sway\Component\Event\EventArgs $args
     * @param object $object
     */
    public function trigger(EventArgs $args, $object)
    {
        foreach($this->listeners as $listener){
            $listener->call($args, $object);
        }
    }
    
    /**
     * Adds event's listener
     * @param \Sway\Component\Event\EventListener $eventListener
     */
    public function listen(EventListener $eventListener)
    {
        array_push($this->listeners, $eventListener);
    }
    
}


?>

