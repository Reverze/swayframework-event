<?php

namespace Sway\Component\Event;

use Sway\Component\Init\Component;
use Sway\Component\Dependency\DependencyInterface;

class Init extends Component
{
    /**
     * Events classses defined in configuration
     * @var array
     */
    private $eventsDefined = array();
    
    /**
     * Event's triggers
     * @var array
     */
    private $eventsTriggers = array();
    
    /**
     *
     * @var \Sway\Component\Event\EventContainer
     */
    private $eventContainer = null;
    
    protected function dependencyController() 
    {
        if ($this->getDependency('framework')->hasCfg('framework/event.register')){
            $this->eventsDefined = $this->getDependency('framework')->getCfg('framework/event.register');
        }
        
        if ($this->getDependency('framework')->hasCfg('framework/event.trigger')){
            $this->eventsTriggers = $this->getDependency('framework')->getCfg('framework/event.trigger');
        }
    }
    
    /**
     * Initializes empty event's container
     * @return \Sway\Component\Event\EventContainer
     */
    public function init() : EventContainer
    {
        $this->eventContainer = EventContainer::create();
        return $this->eventContainer;
    }
    
    public function after()
    {
        $this->eventContainer->registerFromArray($this->eventsDefined);
        $this->eventContainer->listenFromArray($this->eventsTriggers);
    }
    
}


?>