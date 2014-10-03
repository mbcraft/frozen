<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

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