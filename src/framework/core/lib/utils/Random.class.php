<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

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