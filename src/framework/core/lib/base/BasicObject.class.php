<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

require_once("Log.class.php");

class BasicObject
{
    protected function __error($method,$message)
    {
        Log::error($method,$message,$this);
    }

    protected function __warn($method,$message)
    {
        Log::warn($method,$message,$this);
    }

    protected function __info($method,$message)
    {
        Log::info($method,$message,$this);
    }

    protected function __debug($method,$message)
    {
        Log::debug($method,$message,$this);
    }

}

?>