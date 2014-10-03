<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class AutoDateTimePattern implements IActiveRecordPattern
{
    private $field_name;
    
    private $pointcut;
    
    function __construct($field_name,$pointcut)
    {
        if ($pointcut!=ActiveRecordPatterns::BEFORE_INSERT_POINTCUT || $pointcut!=ActiveRecordPatterns::BEFORE_UPDATE_POINTCUT)
            throw new InvalidParameterException("Pointcut non valido!!");
        
        $this->pointcut = $pointcut;
        
        $this->field_name = $field_name;
    }
    
    function needs_apply($peer,$object)
    {
        if (isset($object[$this->field_name])) return true;
        else
            return false;
    }
    
    function apply($peer,$object)
    {
        $object[$this->field_name] = DateTimeUtils::mysql_now();
        
        return array($peer,$object);
    }
    
    function get_pointcut()
    {
        return $this->pointcut;
    }
}

?>