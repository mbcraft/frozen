<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class HashUtils
{
    static function hash_all_by_key($string_as_key,$collection)
    {
        $result = array();
        foreach ($collection as $elem)
        {
            if (is_array($elem))
                $result[$elem[$string_as_key]] = $elem;
            else
                $result[$elem->{$string_as_key}] = $elem;                
        }
        return $result;
    }

    static function hash_all_by_field_num($field_num,$collection,$swap_key=true)
    {
        $result = array();
        foreach($collection as $key => $elem)
        {
            $value = $elem;
            if ($swap_key)
                $value[$field_num] = $key;

            $result[$elem[$field_num]] = $value;
        }
        return $result;
    }
    
    static function group_similar_keys($hash,$groups,$separator)
    {
        $result = array();
        foreach ($groups as $gr)
        {
            $result[$gr] = array();
        }
        
        foreach ($hash as $key => $value)
        {
            if ($value==true)
            {
                foreach ($groups as $gr)
                {
                    if (strpos($key, $gr)===0)
                    {
                        $result[$gr][] = substr($key,strlen($gr)+strlen($separator));
                    }
                }
            }
        }
        return $result;
    }


}
?>