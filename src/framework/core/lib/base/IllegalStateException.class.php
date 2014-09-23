<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class IllegalStateException extends Exception
{
    function __construct($message,$code = null,$previous = null) 
    {
        parent::__construct($message);
    }
}

?>