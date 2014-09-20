<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * Consente di registrare delle call che vengono eseguite prima o dopo determinate operazioni
 */
class ActiveRecordPatterns
{       
    const BEFORE_INSERT_POINTCUT = "before_insert";
    const AFTER_INSERT_POINTCUT = "after_insert";
    
    const BEFORE_UPDATE_POINTCUT = "before_update";
    const AFTER_UPDATE_POINTCUT = "after_update";
    
    const BEFORE_SELECT_POINTCUT = "before_select";
    const AFTER_SELECT_POINTCUT = "after_select";
    
    const BEFORE_DELETE_POINTCUT = "before_delete";
    const AFTER_DELETE_POINTCUT = "after_delete";
    
    
    private static $active_patterns = array();
    
    private static $valid_pointcuts = array(self::BEFORE_INSERT_POINTCUT,self::AFTER_INSERT_POINTCUT,self::BEFORE_UPDATE_POINTCUT,self::AFTER_UPDATE_POINTCUT,self::BEFORE_SELECT_POINTCUT,self::AFTER_SELECT_POINTCUT,self::BEFORE_DELETE_POINTCUT,self::AFTER_DELETE_POINTCUT);
    
    public static function registerPattern($name,$params=null)
    {
        $full_pattern_name = $name."_pattern";
        if ($params!=null)
            $pattern_instance = __create_instance(StringUtils::underscored_to_camel_case($full_pattern_name),$params);
        else
            $pattern_instance = __create_instance(StringUtils::underscored_to_camel_case($full_pattern_name));
        
       $pointcut = $pattern_instance->get_pointcut();
        
       self::check_valid_pointcut($pointcut);
       
       if (!isset(self::$active_patterns[$pointcut])) self::$active_patterns[$pointcut] = array();
       
       self::$active_patterns[$pointcut][] = $pattern_instance;
    }
    
    public static function unregisterAllPatterns()
    {
        self::$active_patterns = array();
    }
    
    public static function getRegisteredPatterns($pointcut)
    {
        self::check_valid_pointcut($pointcut);
        
        if (isset(self::$active_patterns[$pointcut]))
            return self::$active_patterns[$pointcut];
        else return array();
    }
    
    public static function check_valid_pointcut($pointcut)
    {
       if (!self::is_valid_pointcut($pointcut)) throw new InvalidParameterException("Il pointcut ".$pointcut." non e' supportato!!"); 
    }
    
    public static function is_valid_pointcut($pointcut)
    {
        return ArrayUtils::contains_key($pointcut, self::$valid_pointcuts);
    }
    
    private static function apply_patterns_array($result)
    {
        $final_result = array();
        foreach ($result as $k => $v)
        {
            $final_result[] = self::apply_patterns($v);
            
        }
        return $final_result;
    }
    
    private static function apply_patterns($result)
    {
        $current_result = $result;
        foreach ($this->patterns as $pattern_name)
        {
            $pattern_class = __create_instance(StringUtils::underscored_to_camel_case($pattern_name."_pattern"));
            
            if ($pattern_class->needs_apply($result))
                $current_result = $pattern_class->apply($current_result);
            
        }
        return $current_result;
    }
        
}

?>