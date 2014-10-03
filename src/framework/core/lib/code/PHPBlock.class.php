<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class PHPBlock
{
    private $tokens = array();
    private static $open_count = 0;
    private static $started = false;

    function __construct($tokens)
    {
        $this->tokens = $tokens;
    }

    static function fetch($parser,$start)
    {
        $i = $start;

        while (!$this->started || $this->open_count>0)
        {
            $current_token = $parser->getToken($i);

            $token_type = $current_token->getType();
            if ($token_type == PHPToken::T_BLOCK_OPEN)
            {
                $this->started = true;
                $this->open_count++;
            }
            if ($token_type == PHPToken::T_BLOCK_CLOSE)
            {
                $this->open_count--;
            }

            if ($this->started)
                $this->tokens[] = $current_token;

            $i++;
        }

        return $i;
    }

    function innerCode()
    {
        return array_slice($this->tokens,1,count($this->tokens)-2);
    }

    function __toString()
    {
        $code = "";
        foreach ($this->tokens as $tk)
            $code.= $tk;
        return $code;
    }
}

?>