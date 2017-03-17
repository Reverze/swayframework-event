<?php

namespace Sway\Component\Event;

use Sway\Component\Dependency\DependencyInterface;
use Sway\Component\Regex\Regex;
use Sway\Component\Text\Stringify;

class EventContainer extends DependencyInterface
{
    /**
     * Array which contains event's name
     * @var array
     */
    private $events = array();
    
    public function __construct()
    {
        
    }
    
    protected function dependencyController() 
    {
        
    }
    
    /**
     * Creates empty event container
     * @return \Sway\Component\Event\EventContainer
     */
    public static function create() : EventContainer
    {
        $eventContainer = new EventContainer();
        return $eventContainer;
    }
    
    public function registerFromArray(array $eventsArray)
    {
        foreach ($eventsArray as $eventClass){
            
            /**
             * When class is not exists
             */
            if (!class_exists($eventClass)){
                throw Exception\EventException::eventClassNotExists($eventClass);
            }
            
            $this->register(new $eventClass());
        }
    }
    
    /**
     * Registers an new event
     * @param \Sway\Component\Event\Event $event
     */
    public function register(Event $event)
    {
        $this->getDependency('injector')->inject($event);
        $this->events[$event->getName()] = $event;     

    }
    
    /**
     * External trigger event
     * @param string $eventName
     * @param \Sway\Component\Event\EventArgs $args
     * @param object $object
     */
    public function trigger(string $eventName, EventArgs $args, $object)
    {
        /**
         * When event not found
         */
        if (!isset($this->events[$eventName])){
            throw Exception\EventContainerException::eventNotFound($eventName);
        }
        
        $event = $this->events[$eventName];
        $event->trigger($args, $object);
    }
    
    public function listenFromArray(array $eventsTrigger)
    {
        foreach ($eventsTrigger as $eventName => $triggerParameters){          
            foreach ( ($triggerParameters['component'] ?? array()) as $componentListener){
                $exploded = explode(".", $componentListener);
                $componentName = $exploded[0] ?? null;
                $methodName = $exploded[sizeof($exploded) - 1] ?? null;
                $methodNameRegex = '^[a-zA-Z0-9]+\(\)$';
                
                /**
                 * Skips when component's name is empty
                 */
                if (empty($componentName)){
                    break;
                }
                
                /***
                 * If method is not specified
                 */
                if (empty($methodName)){
                   throw Exception\EventContainerException::componentTriggerMethodNotDefined($componentListener);
                }
                
                $regex = new Regex($methodName);
                
                /**
                 * Checks method's name format
                 */
                if (!$regex->isMatch($methodNameRegex)){
                    throw Exception\EventContainerException::invalidComponentMethodName($componentName, $methodName);
                }
                
                /**
                 * Creates an 'callable' array.
                 * When component's name is prefixed by '@' it means that component's object will be used
                 */
                $listener = new EventListener([
                    sprintf("@%s", $componentName),
                    $methodName
                ]);
                
                
                $regex = new Regex($eventName);
                
                if ($regex->isMatch('^on[A-Z][a-zA-Z]*$')){
                    $eventName = Stringify::selectFrom($eventName, 1);
                }
                
                $this->listenOn($eventName, $listener);             
            } 
            
           
        }
    }
    
    public function listenOn(string $eventName, EventListener $eventListener)
    {
        if (!isset($this->events[$eventName])){
            throw Exception\EventContainerException::eventNotFound($eventName);
        }
        
        $this->getDependency('injector')->inject($eventListener);
        $event = $this->events[$eventName];
        $event->listen($eventListener);
        
    }
    
    
}


?>

