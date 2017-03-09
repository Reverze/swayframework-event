<?php

namespace Sway\Component\Event\Listener\Exception;

class ComponentListenerException extends \Exception
{
    /**
     * Throws an exception when dependency' method path is empty
     * @return \Sway\Component\Event\Listener\Exception\ComponentListenerException
     */
    public static function emptyDependencyMethodPath() : ComponentListenerException
    {
        return (new ComponentListenerException(sprintf("Dependency's method path is empty")));
    }
    
    /**
     * Throws an exception when dependency' method path is invalid
     * @param string $invalidDependencyPath
     * @return \Sway\Component\Event\Listener\Exception\ComponentListenerException
     */
    public static function invalidDependencyMethodPath(string $invalidDependencyPath) : ComponentListenerException
    {
        return (new ComponentListenerException(sprintf("Dependency method path is invalid: '%s'", $invalidDependencyPath)));
    }
}


?>

