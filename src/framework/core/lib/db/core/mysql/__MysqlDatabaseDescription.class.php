<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class __MysqlDatabaseDescription extends BasicObject
{
    private $all_tables = array();

    private $exec_done = false;

    protected function exec()
    {
        if (!DB::isConnectionOpen()) $this->__error(__METHOD__, "La connessione al database non e' aperta prima della query.");

        $result = mysql_query("SHOW TABLES;");

        while ($row = mysql_fetch_row($result))
        {
            $this->all_tables[] = $row[0];
        }

        mysql_free_result($result);

        $this->exec_done = true;
    }

    function getAllTables()
    {
        if (!$this->exec_done) $this->exec();
        
        return $this->all_tables;
    }

    function hasTable($table)
    {
        if (!$this->exec_done) $this->exec();

        foreach ($this->all_tables as $id => $table_name)
        {
            if ($table_name==$table) return true;
        }

        return false;
    }
}

?>