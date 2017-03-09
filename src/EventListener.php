<?php

namespace Sway\Component\Event;

use Sway\Component\Dependency\DependencyInterface;
use Sway\Component\Text\Stringify;

class EventListener extends DependencyInterface
{
    /**
     * Listener callable
     * @var mixed
     */
    private $callable = null;
    
    /**
     * Creates listener
     * @param string|array|callable $listener
     */
    public function __construct($listener)
    {
        $this->callable = $listener;
    }
    
    
    public function call(EventArgs $args, $object)
    {
        if (is_callable($this->callable)){
            $callable = $this->callable;
            $callable($args, $object);
        }
        else if (is_string($this->callable)){
            eval($this->callable);
        }
        else if (is_array($this->callable)){
            if ($this->callable[0][0] === '@'){
                $componentName = Stringify::selectFrom($this->callable[0], 0);
                $this->callable[0] = $this->getDependency($componentName);
                
                $methodName = $this->callable[1];
                $methodName = Stringify::replace($methodName, '()', '');
                $this->callable[1] = $methodName;
            }
            
           
            call_user_func_array($this->callable, [
                $args, $object
            ]);
        }
    }
    
    
}


?>

