<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class __MysqlDropView
{
    private $sql;

    function __construct($view_name)
    {
        $this->sql = "DROP VIEW ".$view_name.";";
    }

    function exec()
    {
        mysql_query($this->sql);
    }
}

?>