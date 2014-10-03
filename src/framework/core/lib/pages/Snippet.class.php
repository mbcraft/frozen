<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class Snippet
{
    private static $stack = array();

    const DOMAIN_KEY = "domain";

    static function start($conditions)
    {
        $write_snippet = true;
        foreach ($conditions as $key => $value)
        {
            if ($key===self::DOMAIN_KEY)
                $write_snippet &= self::check_domain($value);
        }
        ob_start();
        array_push(self::$stack,$write_snippet);
    }

    static function end()
    {
        if (empty(self::$stack)) throw new IllegalStateException("Snippet chiuso senza essere aperto!!");
        $write_snippet = array_pop(self::$stack);
        $content = ob_get_contents();
        ob_end_clean();

        if ($write_snippet) echo $content;

    }

    private static function check_domain($domains)
    {
        foreach ($domains as $d)
        {
            if (Host::current()===$d)
                return true;
        }
        return false;
    }
}


?>