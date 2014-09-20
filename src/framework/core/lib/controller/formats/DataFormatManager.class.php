<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
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