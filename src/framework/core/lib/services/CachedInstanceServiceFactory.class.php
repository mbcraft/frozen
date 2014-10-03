<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class CachedInstanceServiceFactory implements IServiceFactory
{
    private $instance;
    
    function __construct($instance)
    {
        $this->instance = $instance;
    }
    
    function getService()
    {
        return $this->instance;
    }
}
?>