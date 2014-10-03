<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class AjaxHelper
{

    function fg_ajax_object_to_json_result($ob)
    {
        echo json_encode($ob);
    }

    /**
     *
     * @param <type> $arr The associative array
     * @param <type> $masked_keys The list of masked keys
     * @param <type> $remove_keys True to remove the keys, false to keep only listed
     */
    static function assoc_to_xml($arr,$masked_keys=array(),$remove_keys=true)
    {
        $keys = array_keys($arr);

        $num_keys = sizeof($keys);
        for ($i=0;$i<$num_keys;$i++)
        {
            $my_key = $keys[$i];

            if ($remove_keys)
            {
                if (!in_array($my_key,$masked_keys))
                {
                    echo "<".$my_key.">";
                    echo $arr[$my_key];
                    echo "</".$my_key.">\n";
                }
            }
            else
            {
                if (in_array($my_key,$masked_keys))
                {
                    echo "<".$my_key.">";
                    echo $arr[$my_key];
                    echo "</".$my_key.">\n";
                }
            }
        }
    }

    static function array_to_xml($arr,$tag_name)
    {
        $num_values = sizeof($arr);
        for ($i=0;$i<$num_values;$i++)
        {
            echo "<".$tag_name.">";
            echo $arr[$i];
            echo "</".$tag_name.">\n";
        }
    }

    static function assoc_array_to_xml($arr,$tag_name,$masked_keys,$remove_keys)
    {
        $num_values = sizeof($arr);
        for ($i=0;$i<$num_values;$i++)
        {
            echo "<".$tag_name.">\n";
            self::assoc_to_xml($arr[$i],$masked_keys,$remove_keys);
            echo "</".$tag_name.">\n";
        }
    }

    static function to_xml_result($arr,$tag_container)
    {
        self::_ajax_result_begin();
        echo "  <".$tag_container.">\n";

        self::assoc_to_xml($arr);

        echo "  </".$tag_container.">\n";
        self::_ajax_result_end();
    }

    static function assoc_array_to_xml_result($arr,$tag_name,$tag_container,$masked_keys=array(),$remove_keys=true)
    {
        self::_ajax_result_begin();
        echo "  <".$tag_container.">\n";

        self::assoc_array_to_xml($arr,$tag_name,$masked_keys,$remove_keys);

        echo "  </".$tag_container.">\n";
        self::_ajax_result_end();
    }

    private static function _ajax_result_begin()
    {
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<result>\n";
    }

    private static function _ajax_result_end()
    {
        echo "</result>\n";
    }
}


function define_json_encode()
{
    if (!function_exists("json_encode"))
    {
        function json_encode($a=false)
        {
            if (is_null($a)) return 'null';
            if ($a === false) return 'false';
            if ($a === true) return 'true';
            if (is_scalar($a))
            {
                if (is_float($a))
                {
                    //Always use "." for floats.
                    return floatval(str_replace(",",".",strval($a)));
                }

                if (is_string($a))
                {
                    static $jsonReplaces = array(array("\\","/","\n","\t","\r","\b","\f",'"'),array("\\\\","\\/","\\n","\\t","\\r","\\b","\\f",'\"'));
                    return '"'.str_replace($jsonReplaces[0],$jsonReplaces[1],$a).'"';
                }
                else
                    return $a;
            }
            $isList = true;
            for ($i=0,reset($a);$i<count($a);$i++,next($a))
            {
                if (key($a)!==$i)
                {
                    $isList = false;
                    break;
                }
            }
            $result = array();
            if ($isList)
            {
                foreach($a as $v) $result[] = json_encode($v);
                return '[' . join(',',$result) . ']';
            }
            else
            {
                foreach($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
                return '{'.join(',',$result).'}';
            }
        }
    }
}

define_json_encode();

?>