<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class PHPParser
{
    private $tokens = array();

    function __construct($code)
    {
        $this->tokens = token_get_all($code);
    }

    function getTokenCount()
    {
        return count($this->tokens);
    }

    function dump()
    {
        for ($i=0;$i<$this->getTokenCount();$i++)
        {
            echo "<br />";
            echo $this->getTokenType($i);
            echo " : ";
            echo $this->getTokenString($i);
        }
    }

    function getTokenType($num)
    {
        if ($num>count($this->tokens) || $num<0) throw new InvalidParameterException("Invalid token number!!");

        $tk = $this->tokens[$num];

        if (is_string($tk))
        {
            switch ($tk)
            {
                case '{': return "T_BLOCK_OPEN";
                case '}': return "T_BLOCK_CLOSE";
                case '[': return "T_ARRAY_INDEX_OPEN";
                case ']': return "T_ARRAY_INDEX_CLOSE";
                case '(': return "T_ROUND_BRACE_OPEN";
                case ')': return "T_ROUND_BRACE_CLOSE";
                case '=': return "T_EQUAL";
                case ',': return "T_COLON";
                case ';': return "T_SEMICOLON";

                default : return "T_STRING";

            }
        }
        else
        {
            list($id,$text) = $tk;
            return token_name($id);
        }
    }

    function getTokenString($num)
    {
        if ($num>count($this->tokens) || $num<0) throw new InvalidParameterException("Invalid token number!!");

        $tk = $this->tokens[$num];

        if (is_string($tk))
            return $tk;
        else
        {
            list($id,$text) = $tk;
            return $text;
        }
    }

    function getToken($num)
    {
        if ($num>count($this->tokens) || $num<0) throw new InvalidParameterException("Invalid token number!!");

        return $this->tokens[$num];
    }
}


?>