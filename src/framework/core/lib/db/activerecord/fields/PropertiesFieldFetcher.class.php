<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

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