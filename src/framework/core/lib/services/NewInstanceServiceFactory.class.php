<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

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