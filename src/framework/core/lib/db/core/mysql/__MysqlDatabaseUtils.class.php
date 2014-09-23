<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */
/*
 * Classe per gestire i database (creazione, eliminazione, rinominazione, elenco).
 * */
class __MysqlDatabaseUtils
{
    const DEFAULT_CHARACTER_SET = "utf8";

    function create_database($database_name,$if_not_exists = true,$default_character_set=self::DEFAULT_CHARACTER_SET)
    {
        $sql = "CREATE DATABASE ";

        if ($if_not_exists)
            $sql.="IF NOT EXISTS ";

        $sql.=$database_name." ";

        if ($default_character_set!=null)
            $sql.="DEFAULT CHARACTER SET ".$default_character_set;

        $sql.=";";

        return mysql_query($sql);
    }

    function drop_database($database_name)
    {
        return mysql_query("DROP DATABASE ".$database_name.";");
    }

    function rename_database($old_name,$new_name)
    {
        return mysql_query("RENAME DATABASE ".$old_name." TO ".$new_name.";");
    }

    function get_database_list()
    {
        return mysql_list_dbs();
    }

    function switch_database($database_name)
    {
        mysql_select_db($database_name);
    }

    function has_database($database_name)
    {
        $database_list = $this->get_database_list();

        return ArrayUtils::has_value($database_list,$database_name);
    }

    function get_current_database()
    {
        return mysql_dbname();
    }
}

?>