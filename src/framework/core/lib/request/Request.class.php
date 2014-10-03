<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class Request
{

    private static function __splitWithPercentage($data_string)
    {
        $data_array = explode(",",$data_string);
        $result = array();
        foreach ($data_array as $data)
        {
            $data_tok = explode(";",$data);
        if (count($data_tok)>1)
        {
            $result[$data_tok[0]] = str_replace("q=","",$data_tok[1]);
        }
        else
            $result[$data_tok[0]] = 1;
        }
        return $result;

    }

    public static function getRequestTime()
    {
        return $_SERVER["REQUEST_TIME"];
    }

    public static function getAcceptedLanguages()
    {
        $languages = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
        return self::__splitWithPercentage($languages);
    }

    public static function getAcceptedMimeTypes()
    {
        $mime_types = $_SERVER["HTTP_ACCEPT"];
        return self::__splitWithPercentage($mime_types);
    }

    public static function getAcceptedEncodings()
    {
        $accepted_encodings = $_SERVER["HTTP_ACCEPT_ENCODING"];
        return self::__splitWithPercentage($accepted_encodings);
    }

    public static function getRemoteIp()
    {
        return $_SERVER["REMOTE_ADDR"];
    }

    public static function getRequestFormat($full_request_uri=null)
    {
        $ru = self::getRequestPart($full_request_uri);

        $tokens = explode(".",$ru);

        return $tokens[count($tokens)-1];
    }

    public static function getRequestPath($full_request_uri=null)
    {
        $ru = self::getRequestPart($full_request_uri);

        $tokens = explode("?",$ru);

        $request_part = $tokens[0];

        $path_parts = explode("/",$request_part);

        $path = "";
        for ($i=0;$i<count($path_parts)-1;$i++)
        {
            $path.=$path_parts[$i]."/";
        }

        return $path;
    }

    public static function getRequestName($full_request_uri=null)
    {
        $ru = self::getRequestPart($full_request_uri);

        $tokens = explode("?",$ru);

        $request_part = $tokens[0];

        $path_parts = explode("/",$request_part);

        $last_token = $path_parts[count($path_parts)-1];

        $name_and_format = explode(".",$last_token);

        return $name_and_format[0];
                
    }

    public static function getRequestUri()
    {
        if (isset($_SERVER["REQUEST_URI"]))
            return $_SERVER["REQUEST_URI"];
        else
            return $_SERVER["SCRIPT_NAME"];
    }
    
    public static function getRequestPart($full_request_uri=null)
    {
        if ($full_request_uri===null)
            $full_request_uri = Request::getRequestUri();
        
        $path_parts = explode("?",$full_request_uri);
        
        $request_part = $path_parts[0];
        
        if ($request_part==="") $request_part.="/";
        
        if (strpos($request_part, "/",strlen($request_part)-1)===(strlen($request_part)-1))
                $request_part.="index.php";
    
        return $request_part;
    }
    
    public static function getParametersPart($full_request_uri=null)
    {
        if ($full_request_uri===null)
            $full_request_uri = Request::getRequestUri();
        
        $path_parts = explode("?",$full_request_uri);
        if (count($path_parts)>1)
        {
            $parameters_part = $path_parts[1];
        
            return $parameters_part;
        }
        
        return null;
    }
}

?>