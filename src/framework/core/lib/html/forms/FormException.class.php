<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class FormException extends Exception
{
    function __construct($message) 
    {
        parent::__construct($message, 0, 0);
    }
}
?>