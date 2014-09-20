<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class PHPClass
{
    private $name,$extends,$implements=array();
    
    private $static_functions=array();
    private $functions=array();
    
    private $consts=array();
    private $variables=array();
    private $static_variables=array();

    function __construct($name,$extends=null,$implements=array())
    {
        $this->name = $name;
        $this->extends = $extends;
        $this->implements = $implements;
    }
    
    function getName()
    {
        return $this->name;
    }
    
    function addInterface($interface_name)
    {
        $this->implements[] = $interface_name;
    }
    
    function addFunction($function,$is_static=false)
    {
        if ($function instanceof PHPFunction)
        {
            if ($is_static)
                $this->static_functions[] = $function;
            else
                $this->functions[] = $function;
        }
        else throw new Exception("La funzione non è un'istanza di PHPFunction");
    }

    function addConst($const_name,$const_value)
    {
        $this->consts[$const_name] = $const_value;
    }
        
    function addVariable($variable,$is_static=false)
    {
        if ($variable instanceof PHPDeclaredVariable)
        {
            if ($is_static)
                $this->static_variables[] = $variable;
            else
                $this->variables[] = $variable;
        }
    }

}

?>