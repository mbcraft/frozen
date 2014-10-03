<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class StringUtils
{

    static function underscored_to_camel_case($string)
    {
            $string[0] = strtoupper($string[0]);

            $func = create_function('$c', 'return strtoupper($c[1]);');
            return preg_replace_callback('/_([a-z])/', $func, $string);
    }
    /*
     * Questa funzione splitta i nomi camelcase mettendo gli underscore secondo la seguente regola :
     * 
     * FPDF -> fpdf
     * ContenutiTestualiController -> contenuti_testuali_controller
     * */
    static function camel_case_split($string,$skip_last=false,$join_part="_")
    {
        $matches = array();
        preg_match_all("/([A-Z]+[A-Z](?![a-z]))|([A-Z]+[a-z]*)/",$string,$matches); //black magic, do not touch ...
        $real_matches = $matches[0];

        $lower_matches = array();
        foreach ($real_matches as $mtc)
            $lower_matches[] = strtolower($mtc);

        if ($skip_last)
            array_pop($lower_matches);

        return join($join_part,$lower_matches);
    }

    static function trim_ending_chars($string,$num)
    {
        if ($num>strlen($string)) throw new InvalidParameterException("Numero di caratteri piu' lungo della stringa!!");
        return substr($string,0,-$num);
    }

    static function ends_with($string,$suffix)
    {
        return strpos($string,$suffix)===(strlen($string)-strlen($suffix));
    }

    static function starts_with($string,$prefix)
    {
        return substr($string,0,strlen($prefix))===$prefix;
    }
    
}

?>