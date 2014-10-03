<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

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