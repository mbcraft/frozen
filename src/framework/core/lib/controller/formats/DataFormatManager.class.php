<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
class DataFormatManager
{
    static function checkFormatSupported($format)
    {
        if (!self::isFormatSupported($format))
            throw new InvalidParameterException("Formato non supportato : ".$format);
    }

    static function getFormat($format)
    {
        switch ($format)
        {
            case "xml" : return new XMLDataFormat();
            case "rawp" : return new RAWPhpDataFormat();
            case "json" : return new JSONDataFormat();
            case "html" :
            case "php" : return new HTMLDataFormat();
            default : throw new InvalidParameterException("Data format not supported!!");
        }
    }
    
    static function isFormatSupported($format)
    {
        switch ($format)
        {
            case "xml" : 
            case "rawp" : 
            case "json" : 
            case "html" :
            case "php" : return true;
            default : return false;
        }
    }
    
    
    
}

?>