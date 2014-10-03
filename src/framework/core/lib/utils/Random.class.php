<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class Random
{
    
    static function newHexString()
    {
        return dechex(self::newBigNum());
    }
    
    static function newBigNum()
    {
        return rand(100000000,1000000000);
    }
    
    static function newFloatRand()
    {
        return (float)(rand(0,1000000000))/(float)(1000000000);
    }
    
}

?>