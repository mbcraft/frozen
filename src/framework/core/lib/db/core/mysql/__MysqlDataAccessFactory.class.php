<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
        $db_name = Config::instance()->DB_NAME;
        $db_hostname = Config::instance()->DB_HOSTNAME;
        $db_username = Config::instance()->DB_USERNAME;
        $db_password = Config::instance()->DB_PASSWORD;
        $db_persistent_connection = Config::instance()->DB_PERSISTENT_CONNECTION;
 *
 */

class __MysqlDataAccessFactory extends BasicObject implements __DataAccessFactory
{
    private $connectionOpened = false;
    private $persistentConnection;

    public function openConnection($db_name,$db_hostname,$db_username,$db_password,$db_persistent_connection)
    {
        if ($db_persistent_connection)
        {
            //connessione persistente
            $result_conn = mysql_pconnect($db_hostname,$db_username,$db_password);
        }
        else
        {
            //connessione non persistente
            $result_conn = mysql_connect($db_hostname,$db_username,$db_password);
        }

        if (!$result_conn)
        {
            $this->__error(__METHOD__,"Impossibile effettuare il collegamento al database.");
            return;
        }
        $this->persistentConnection = $db_persistent_connection;
        $result_select_db = mysql_select_db($db_name);
        if (!$result_select_db)
        {
            $this->__error(__METHOD__,"Impossibile selezionare il database corretto.");
            return;
        }
        
        $this->connectionOpened = true;

    }

    public function isConnectionOpen()
    {
        return $this->connectionOpened;
    }

    public function closeConnection()
    {
        if (!$this->persistentConnection)
            mysql_close();
            
        $this->connectionOpened = false;
    }

    public function newSelect($table)
    {
        return new __MysqlSelect($table);
    }

    public function newInsert($table)
    {
        return new __MysqlInsert($table);
    }

    public function newUpdate($table)
    {
        return new __MysqlUpdate($table);
    }

    public function newDelete($table)
    {
        return new __MysqlDelete($table);
    }

    public function newTableDataImportExport()
    {
        return new __MysqlTableDataImportExport();
    }

    public function newTableStatus($table)
    {
        return new __MysqlTableStatus($table);
    }

    public function newTableFieldsDescription($table)
    {
        return new __MysqlTableFieldsDescription($table);
    }

    public function newDatabaseDescription()
    {
        return new __MysqlDatabaseDescription();
    }

    public function newDirectSql($sql)
    {
        return new __MysqlQuery($sql);
    }

    public function newCreateTable($table_name)
    {
        return new __MysqlCreateTable($table_name);
    }

    public function newAlterTable($table_name)
    {
        return new __MysqlAlterTable($table_name);
    }

    public function newDropTable($table_name)
    {
        return new __MysqlDropTable($table_name);
    }

    public function newDatabaseUtils()
    {
        return new __MysqlDatabaseUtils();
    }

    public function newInfo()
    {
        return new __MysqlInfo();
    }

    public function newCreateView($view_name)
    {
        return new __MysqlCreateView($view_name);
    }

    public function newAlterView($view_name)
    {
        return new __MysqlAlterView($view_name);
    }

    public function newDropView($view_name)
    {
        return new __MysqlDropView($view_name);
    }
    
    public function newQueryUtils()
    {
        return new __MysqlQueryUtils();
    }
    
}

?>