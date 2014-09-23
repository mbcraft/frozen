<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

interface __DataAccessFactory
{
    function openConnection($db_name,$db_hostname,$db_username,$db_password,$db_persistent_connection);
    function isConnectionOpen();
    function closeConnection();
    function newSelect($table);
    function newInsert($table);
    function newUpdate($table);
    function newDelete($table);
    function newDirectSql($sql);
    function newTableDataImportExport();
    function newDatabaseDescription();
    function newTableStatus($table);
    function newTableFieldsDescription($table);
    function newCreateTable($table);
    function newDropTable($table);
    function newAlterTable($table);
    function newDatabaseUtils();
    function newInfo();
    function newCreateView($view_name);
    function newAlterView($view_name);
    function newDropView($view_name);

}

?>