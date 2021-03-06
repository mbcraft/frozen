<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class __MysqlDatabaseDescription
{
    private $all_tables = array();

    private $exec_done = false;

    protected function exec()
    {
        if (!DB::isConnectionOpen()) Log::error(__METHOD__, "La connessione al database non e' aperta prima della query.");

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