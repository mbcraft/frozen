<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class NewInstanceServiceFactory implements IServiceFactory
{
    private $class_name;
    
    function __construct($class_name) 
    {
        $this->class_name = $class_name;
    }
    
    function getService()
    {
        return __create_instance($this->class_name);
    }
}
?>