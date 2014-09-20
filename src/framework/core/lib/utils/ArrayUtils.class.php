<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class ArrayUtils
{
    static function has_value($array,$value)
    {
        if ($array===null || count($array)===0) return false;
        foreach ($array as $k => $val)
        {
            if ($val===$value)
                return true;
        }
        return false;
    }
    
    static function reorder_from_zero(&$array)
    {
        $keys = array_keys($array);
        
        sort($keys);
        
        $re_index = 0;
        $reordered = array();
        foreach ($keys as $k)
        {
            $reordered[$re_index] = $array[$k];
            $re_index+=1;
        }

        $array = $reordered;
    }

    static function join($array,$join)
    {
        $result = "";
        foreach ($array as $elem)
        {
            $result .= $elem.$join;
        }
        return substr($result,0,strlen($result)-strlen($join));
    }

    static function contains_key($key,$searcharray)
    {
        return array_key_exists($key, $searcharray);
    }

    static function delete_keys($array1,$array2)
    {
        $keys2 = array_keys($array2);

        foreach ($keys2 as $k)
            unset($array1[$k]);

        return $array1;

    }

}

?>