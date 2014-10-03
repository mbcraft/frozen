<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class PropertiesFieldFetcher extends AbstractFieldFetcher
{
    function rawToLogic($raw_value)
    {
        return PropertiesUtils::readFromString($raw_value,false);
    }

    function logicToRaw($logic_value)
    {
        return PropertiesUtils::saveToString($logic_value,false);
    }

}

?>