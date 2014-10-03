<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class __MysqlDropTable
{
    protected $my_table;

    public function __construct($my_table)
    {
        $this->my_table = $my_table;
    }

    public function exec()
    {
        $sql = "DROP TABLE ".$this->my_table.";";
        $result = mysql_query($sql);
        mysql_query("FLUSH TABLES;");
        return $result;
    }
}

?>