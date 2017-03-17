<?php

namespace Sway\Component\Event\Listener;

use Sway\Component\Dependency\DependencyInterface;
use Sway\Component\Event;
use Sway\Component\Event\Exception;
use Sway\Component\Dependency\Exception\DependencyException;

class ComponentListener extends Event\EventListener
{
    /**
     * Component's name (dependency)
     * @var string
     */
    private $componentName = null;
    
    /**
     * 
     * @var array
     */
    private $methodTraceArray = null;
    
    
    public function __construct(string $dependencyMethodPath = null)
    {
        if (empty($this->methodTraceArray)){
            $this->methodTraceArray = array();
        }
        /**
         * If method path is passed
         */
        if (!empty($dependencyMethodPath)){
            $this->decodeDependencyMethodPath($dependencyMethodPath);
        }
    }
    
    protected function dependencyController() 
    {
        //nothing to do here
    }
    
    /**
     * Decodes dependency's method path
     * @param string $dependencyMethodPath
     * @throws \Sway\Component\Event\Listener\Exception\ComponentListenerException
     */
    protected function decodeDependencyMethodPath(string $dependencyMethodPath)
    {
        if (!strlen($dependencyMethodPath)){
            throw Exception\ComponentListenerException::emptyDependencyMethodPath();
        }
        
        $explodedPath = explode(".", $dependencyMethodPath);
        
        if (!sizeof($explodedPath)){
            throw Exception\ComponentListenerException::invalidDependencyMethodPath($dependencyMethodPath);
        }
        
        /**
         * First key in array means component's name
         */
        $this->componentName = $explodedPath[0];
        
        /**
         * Stores method trace array
         */
        for ($i = 1; $i < sizeof($explodedPath); $i++){
            array_push($this->methodTraceArray, $explodedPath[$i]);
        }
        
    }
}


?>
