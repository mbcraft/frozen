<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class Result
{
    static function is_result($data)
    {

        return is_array($data) && isset($data["result"]);
    }

    static function ok()
    {
        return array("result" => "ok");
    }

    static function is_ok($result)
    {
        return $result["result"]==="ok";
    }

    static function is_warning($result)
    {
        return $result["result"]==="warning";
    }

    static function warning($message)
    {
        return array("result" => "warning","warning" => $message);
    }

    static function is_error($result)
    {
        return $result["result"]==="error";
    }

    static function error($message_or_exception)
    {
        if ($message_or_exception instanceof Exception)
            return array("result" => "error","error" => $message_or_exception->getMessage());
        else
            return array("result" => "error","error" => $message_or_exception);

    }

}


?>