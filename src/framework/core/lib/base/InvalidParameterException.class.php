<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class InvalidParameterException extends Exception
{
    function __construct($message,$code = null,$previous = null)
    {
        parent::__construct($message);
    }
}
?>