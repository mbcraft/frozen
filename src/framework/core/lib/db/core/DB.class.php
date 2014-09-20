<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class DB extends BasicObject
{
    private static $initialized = false;
    private static $instance;

    private $dataAccessFactoryClass;
    private $dataAccessFactory;

    public function __construct($data_access_factory_class = "__MysqlDataAccessFactory")
    {
        $this->dataAccessFactoryClass = $data_access_factory_class;
        $this->dataAccessFactory = __create_instance($data_access_factory_class);
    }

    public static function setDataAccessFactory($data_access_factory_class)
    {
        self::$instance = new DB($data_access_factory_class);
    }

    public function getDataAccessFactoryClass()
    {
        return $this->dataAccessFactoryClass;
    }

    private static function __init()
    {
        self::$initialized = true;
        self::$instance = new DB();
    }

    public static function isConnectionOpen()
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->isConnectionOpen();
    }

    public static function openDefaultConnection()
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->openConnection(Config::instance()->DB_NAME,Config::instance()->DB_HOSTNAME,Config::instance()->DB_USERNAME,Config::instance()->DB_PASSWORD,Config::instance()->DB_PERSISTENT_CONNECTION);
    }

    public static function openConnection($db_name,$db_hostname,$db_username,$db_password,$db_persistent_connection)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->openConnection($db_name,$db_hostname,$db_username,$db_password,$db_persistent_connection);
    }

    public static function closeConnection()
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->closeConnection();
    }

    public static function newSelect($table)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newSelect($table);
    }

    public static function newUpdate($table)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newUpdate($table);
    }

    public static function newInsert($table)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newInsert($table);
    }

    public static function newDelete($table)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newDelete($table);
    }

    public static function newTableDataImportExport()
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newTableDataImportExport();
    }

    public static function newTableStatus($table)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newTableStatus($table);
    }

    public static function newTableFieldsDescription($table)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newTableFieldsDescription($table);
    }

    public static function newDatabaseDescription()
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newDatabaseDescription();
    }

    public static function newDirectSql($sql)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newDirectSql($sql);
    }

    public static function newCreateTable($table_name)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newCreateTable($table_name);
    }

    public static function newAlterTable($table_name)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newAlterTable($table_name);
    }

    public static function newDropTable($table_name)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newDropTable($table_name);
    }

    public static function newDatabaseUtils()
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newDatabaseUtils();
    }

    public static function newInfo()
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newInfo();
    }

    public static function newCreateView($view_name)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newCreateView($view_name);
    }

    public static function newAlterView($view_name)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newAlterView($view_name);
    }

    public static function newDropView($view_name)
    {
        if (!self::$initialized) self::__init();
        return self::$instance->dataAccessFactory->newDropView($view_name);
    }
}

?>