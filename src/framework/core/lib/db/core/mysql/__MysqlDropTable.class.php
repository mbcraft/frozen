<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

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