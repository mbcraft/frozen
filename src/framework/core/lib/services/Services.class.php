<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class Services
{
    private static $service_factories = array();
    
    static function registerServiceFactory($name,$factory)
    {
        self::$service_factories[$name] = $factory;
    }
    
    static function unregisterService($name)
    {
        if (isset(self::$service_factories[$name]))
            unset(self::$service_factories[$name]);
    }
    
    static function unregisterAllServices()
    {
        self::$service_factories = array();
    }
    
    static function is_registered($name)
    {
        return array_key_exists($name, self::$service_factories);
    }
    
    static function get_all_registered_services()
    {
        return array_keys(self::$service_factories);
    }

    static function get($name)
    {
        $factory = self::$service_factories[$name];
        return $factory->getService();
    }
    
    
    
}
?>