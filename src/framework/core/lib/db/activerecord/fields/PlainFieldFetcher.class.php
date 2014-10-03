<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

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

