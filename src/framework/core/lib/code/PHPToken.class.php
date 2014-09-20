<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class PHPToken
{
    const T_BLOCK_OPEN="{",T_BLOCK_CLOSE="}",T_ARRAY_INDEX_OPEN="[",T_ARRAY_INDEX_CLOSE="]",
    T_ROUND_BRACE_OPEN="(",T_ROUND_BRACE_CLOSE=")",T_EQUAL="=",T_COLON=",",T_SEMICOLON=";";

    private $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    function __toString()
    {
        return $this->getString();
    }

    function getType()
    {

        if (is_string($this->data))
        {
            switch ($this->data)
            {
                case T_BLOCK_OPEN: return "T_BLOCK_OPEN";
                case T_BLOCK_CLOSE: return "T_BLOCK_CLOSE";
                case T_ARRAY_INDEX_OPEN: return "T_ARRAY_INDEX_OPEN";
                case T_ARRAY_INDEX_CLOSE: return "T_ARRAY_INDEX_CLOSE";
                case T_ROUND_BRACE_OPEN: return "T_ROUND_BRACE_OPEN";
                case T_ROUND_BRACE_CLOSE: return "T_ROUND_BRACE_CLOSE";
                case T_EQUAL: return "T_EQUAL";
                case T_COLON: return "T_COLON";
                case T_SEMICOLON: return "T_SEMICOLON";

                default : return "T_STRING";

            }
        }
        else
        {
            list($id,$text) = $this->data;
            return token_name($id);
        }
    }

    function getString()
    {
        if (is_string($this->data))
            return $this->data;
        else
        {
            list($id,$text) = $this->data;
            return $text;
        }
    }
}

?>