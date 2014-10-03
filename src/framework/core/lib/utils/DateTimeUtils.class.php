<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class DateTimeUtils
{
    static function read_from_params($param_name)
    {
        $date_string = str_replace("/","-",Params::get($param_name));
        $date = new DateTime($date_string);
        return $date;
    }

    static function write_datetime_from_object($date)
    {
        return date_format($date,"Y-m-d H:i:s");
    }

    static function write_date_from_object($date)
    {
        return date_format($date,"Y-m-d");
    }

    static function mysql_now()
    {
        return date("Y-m-d H:i");
    }
    
    static function mysql_now_date()
    {
        return date("Y-m-d");
    }

    static function to_date($date)
    {
        $time = strtotime($date);
        return date("d-m-Y",$time);
    }

    static function to_time_and_date($date)
    {
        $time = strtotime($date);
        return date("H:i d-m-Y",$time);
    }

    static function year_yyyy_mm_dd($date)
    {

        $date = str_replace("/", "-", $date);
        $tokens = explode("-",$date);
        return $tokens[0];
    }

    static function month_yyyy_mm_dd($date)
    {
        $date = str_replace("/", "-", $date);
        $tokens = explode("-",$date);
        return $tokens[1];
    }

    static function day_yyyy_mm_dd($date)
    {
        $date = str_replace("/", "-", $date);
        $tokens = explode("-",$date);
        return $tokens[2];
    }

    static function reverse_date_yyyy_mm_dd($date)
    {
        if (preg_match("/\d\d\d\d[-\/]\d\d[-\/]\d\d/",$date))
        {
            $date = str_replace("/", "-", $date);
            $tokens = explode("-",$date);
            return $tokens[2]."-".$tokens[1]."-".$tokens[0];
        }
        else throw new InvalidParameterException("Formato data non valido!");
    }


    static function reverse_date_dd_mm_yyyy($date)
    {
        if (preg_match("/\d\d[-\/]\d\d[-\/]\d\d\d\d/",$date))
        {
            $date = str_replace("/", "-", $date);
            $tokens = explode("-",$date);
            return $tokens[2]."-".$tokens[1]."-".$tokens[0];
        }
        else throw new InvalidParameterException("Formato data non valido!");
    }

}

?>