<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class ActiveRecord
{
    private static $raw_classes_registered = array();

    public static $cachedTables=array();
    public static $cachedAllFields=array();
    public static $cachedPrimaryKeyFields=array();

    public static function init($raw_class_name)
    {
        if ($raw_class_name=="Abstract") return;

        if (!array_key_exists($raw_class_name, self::$raw_classes_registered))
        {
            self::$raw_classes_registered[] = $raw_class_name;

            self::initTable($raw_class_name);
            self::initAllFields($raw_class_name);
            self::initPrimaryKeyFields($raw_class_name);
        }

    }

    public static function refreshLoadedTables()
    {
        $keys = array_keys(self::$cachedTables);

        foreach ($keys as $key)
        {
            self::initAllFields($key);
            self::initPrimaryKeyFields($key);
        }
    }

    public static function dispose()
    {
        self::$cachedAllFields = array();
        self::$cachedPrimaryKeyFields = array();
        self::$cachedTables = array();
    }

    private static function __askPeer($raw_class_name,$method)
    {
        $class_name = $raw_class_name."Peer";
        $peer = __create_instance($class_name);
        return $peer->{$method}();
    }

    private static function initTable($raw_class_name)
    {
        $table_name = self::__askPeer($raw_class_name,"__getMyTable");
        self::$cachedTables[$raw_class_name] = $table_name;
    }

    private static function initAllFields($raw_class_name)
    {
        $table = self::$cachedTables[$raw_class_name];
        $table_description = DB::newTableFieldsDescription($table);

        $all_fields = $table_description->getAllFields();
        self::$cachedAllFields[$raw_class_name] = $all_fields;
    }

    private static function initPrimaryKeyFields($raw_class_name)
    {
        $table = self::$cachedTables[$raw_class_name];
        $table_description = DB::newTableFieldsDescription($table);

        $pk_fields = $table_description->getPrimaryKeyFields();
        self::$cachedPrimaryKeyFields[$raw_class_name] = $pk_fields;
    }

    public static function getPrimaryKeyFields($raw_class_name)
    {
        return self::$cachedPrimaryKeyFields[$raw_class_name];
    }

    public static function print_registered_classes()
    {
        return implode(", ",self::$raw_classes_registered);
    }

    public static function print_tables()
    {
        return implode(", ",self::$cachedTables);
    }

    public static function print_fields_for_class($raw_class_name)
    {
        return implode(", ",self::$cachedAllFields[$raw_class_name]);
    }

    public static function has_table_for_class($raw_class_name)
    {
        return array_key_exists($raw_class_name, self::$cachedTables);
    }

    public static function get_table_for_class($raw_class_name)
    {
        return self::$cachedTables[$raw_class_name];
    }

    public static function has_field_for_class($raw_class_name,$field)
    {
        if (self::has_table_for_class($raw_class_name))
            return array_key_exists($field, self::$cachedAllFields[$raw_class_name]);
        else
            throw new ActiveRecordException("La classe ".$raw_class_name." non è registrata in ActiveRecord.");
    }
    


}
?>