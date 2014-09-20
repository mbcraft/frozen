<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class PHPFunction
{
    private $is_abstract;
    private $is_static;
    private $scope;
    private $name;
    private $block;
    
    function __construct($scope,$name,$is_static,$block=null)
    {
        $this->scope = $scope;
        $this->name = $name;
        $this->is_static = $is_static;
        if ($block==null)
            $this->is_abstract = true;
        else
        {
            $this->is_abstract = false;
            $this->block = $block;
        }
    }
    
    function isStatic()
    {
        return $this->is_static;
    }

    function isAbstract()
    {
        return $this->is_abstract;
    }

    function getScope()
    {
        return $this->scope;
    }
 }

?>