<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class PlainFieldFetcher extends AbstractFieldFetcher
{
    function rawToLogic($raw_value)
    {
        return $raw_value;
    }

    function logicToRaw($logic_value)
    {
        return $logic_value;
    }
}

?>

