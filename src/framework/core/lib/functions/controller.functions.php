<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

function call($controller_name,$action_and_format,$params=null)
{
    $tokens = explode(".",$action_and_format);
    $token_count = count($tokens);

    switch ($token_count)
    {
        case 1: return CallStack::call($controller_name,$tokens[0],"rawp",$params);
        case 2: return CallStack::call($controller_name,$tokens[0],$tokens[1],$params);
        default : throw new InvalidParameterException("Nome della action non valido!! : ".$action_and_format);
    }
}

?>