<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
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