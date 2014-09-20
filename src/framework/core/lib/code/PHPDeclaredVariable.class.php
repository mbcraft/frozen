<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class PHPDeclaredVariable
{
    private $name;
    private $value=null;
    private $scope;

    function __construct($name,$value=null,$scope=null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->scope = $scope;
    }
}

?>