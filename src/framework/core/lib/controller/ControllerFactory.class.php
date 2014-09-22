<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class ControllerFactory
{
    const CONTROLLER_NAME_SUFFIX = "Controller";

    private static $initialized = false;
    private static $instance = null;

    private $controllers;

    private function __construct()
    {
        $this->controllers = array();
        $class_keys = ClassLoader::instance()->get_element_keys();

        foreach ($class_keys as $key)
        {
            if (self::is_controller_class($key))
            {
                $controller_name = self::get_controller_name_from_class($key);
                if ($controller_name=="abstract" || $controller_name=="i") continue;
                $this->controllers[$controller_name] = $key;
            }
        }
    }

    private static function init()
    {
        self::$initialized = true;
        self::$instance = new ControllerFactory();
    }

    public static function is_controller_class($class_name)
    {
        return StringUtils::ends_with($class_name,self::CONTROLLER_NAME_SUFFIX);
    }

    /*
     * Toglie tutti i trattini -
     * Toglie tutti gli underscore iniziali
     * Toglie tutti gli underscore finali
     * Lascia un solo undescore se non sono all'inizio o alla fine
     * Toglie il suffisso Controller
     * mette in lowercase
     */

    public static function get_controller_class_from_name($controller_name)
    {
        return StringUtils::underscored_to_camel_case($controller_name).self::CONTROLLER_NAME_SUFFIX;
    }

    public static function get_controller_name_from_class($class_name)
    {
        $trimmed_name = substr($class_name,0,strlen($class_name)-strlen(self::CONTROLLER_NAME_SUFFIX));

        return StringUtils::camel_case_split($trimmed_name);
    }

    public static function create($controller_name)
    {
        if (!self::$initialized) self::init();

        if (self::can_create($controller_name))
        {
            $controller_class = self::get_controller_class_from_name($controller_name);
            $controller = __create_instance($controller_class);
            return $controller;
        }
        else
            Log::error(__METHOD__, "Non posso creare il controller $controller_name .");
    }

    public static function can_create($controller_name)
    {
        if (!self::$initialized) self::init();
        
        return array_key_exists($controller_name, self::$instance->controllers) || class_exists(self::get_controller_class_from_name($controller_name));
    }

    public static function get_controller_names()
    {
        if (!self::$initialized) self::init();

        return array_keys(self::$instance->controllers);
    }

}

?>