<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * Fetcher per date. Supporta l'attributo writable per date non modificabili.
 * */
class DateFieldFetcher extends AbstractFieldFetcher
{
    function rawToLogic($raw_value)
    {
        return DateTimeUtils::reverse_date_yyyy_mm_dd($raw_value);
    }

    function logicToRaw($logic_value)
    {
        return DateTimeUtils::reverse_date_dd_mm_yyyy($logic_value);
    }



}

?>