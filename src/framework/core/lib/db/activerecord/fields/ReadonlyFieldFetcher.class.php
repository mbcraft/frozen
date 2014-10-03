<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * Fetcher per campi di default. Utilizzabile anche per la chiave primaria (non modificabile).
 * */
class ReadonlyFieldFetcher extends AbstractFieldFetcher
{
    function rawToLogic($raw_value)
    {
        return $raw_value;
    }

    function logicToRaw($logic_value)
    {
        return $logic_value;
    }

    function isWritable()
    {
        return false;
    }
}

?>