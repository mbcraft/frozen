<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

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