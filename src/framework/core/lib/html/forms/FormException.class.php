<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
class FormException extends Exception
{
    function __construct($message) 
    {
        parent::__construct($message, 0, 0);
    }
}
?>