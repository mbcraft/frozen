<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

function is_html()
{
    $format = CallStack::peek()->get_format();
    return $format=="html" || $format=="php";
}

function is_json()
{
return CallStack::peek()->get_format()=="json";
}

function is_phpdata()
{
    return CallStack::peek()->get_format()=="rawp";
}

function is_xml()
{
    return CallStack::peek()->get_format()=="xml";
}

class CallStack
{
    private static $call_stack = array();

    public static function call($controller_name,$action,$format,$params)
    {
        $c = new ControllerCall($controller_name,$action,$format,$params);

        self::push($c);
        //imposto i parametri in base al formato

        //fine setup parametri
        self::execute_top();
        //leggo il risultato

        $executed_call = self::pop();
        return $executed_call->__action_result();
    }
    
    public static function push($call)
    {
        array_push(self::$call_stack,$call);
    }

    public static function pop()
    {
        if (count(self::$call_stack)===0) throw new IllegalStateException("Lo stack delle chiamate e' vuoto!! Impossibile eseguire CallStack::pop");
        return array_pop(self::$call_stack);
    }

    public static function peek()
    {
        if (count(self::$call_stack)===0)
            return null;

        return array_last(self::$call_stack);
    }

    private static function execute_top()
    {
        self::peek()->execute();
    }

    public static function dump()
    {
        var_dump(self::$call_stack);
    }

}

?>