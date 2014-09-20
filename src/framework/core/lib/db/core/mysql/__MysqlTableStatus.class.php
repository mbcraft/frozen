<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class __MysqlTableStatus extends __AbstractMysql
{
    private $exec_done = false;

    private $data;

    private $num_rows_result;

    public function __sql_show_status()
    {
        $this->sql = "SHOW TABLE STATUS LIKE '".$this->my_table."';";
    }

    protected function exec()
    {
        if (!DB::isConnectionOpen()) $this->__error(__METHOD__, "La connessione al database non e' aperta prima della query.");

        $result = mysql_query($this->sql);
        if ($result)
            $this->num_rows_result = mysql_num_rows($result);
        else
            $this->num_rows_result = 0;

        $this->exec_done = true;

        return $result;
    }

    protected function __get_table_description()
    {
        if (!$this->exec_done)
        {
            $this->__sql_show_status();
            $result = $this->exec();

            $this->data = $this->__fetch_assoc($result);

            if ($result!=false) mysql_free_result($result);

            $this->exec_done = true;
        }
        return $this->data;
    }

    public function reload()
    {
        $this->exec_done = false;
    }

    public function getName()
    {
        $result = $this->__get_table_description();

        return $result["Name"];
    }

    public function getEngine()
    {
        $result = $this->__get_table_description();

        return $result["Engine"];
    }

    public function getVersion()
    {
        $result = $this->__get_table_description();

        return $result["Version"];
    }

    public function getRowFormat()
    {
        $result = $this->__get_table_description();

        return $result["Row_format"];
    }

    public function getRows()
    {
        $result = $this->__get_table_description();

        return $result["Rows"];
    }

    public function getAvgRowLength()
    {
        $result = $this->__get_table_description();

        return $result["Avg_row_length"];
    }

    public function getDataLength()
    {
        $result = $this->__get_table_description();

        return $result["Data_length"];
    }

    public function getMaxDataLength()
    {
        $result = $this->__get_table_description();

        return $result["Max_data_length"];
    }

    public function getIndexLength()
    {
        $result = $this->__get_table_description();

        return $result["Index_length"];
    }

    public function getDataFree()
    {
        $result = $this->__get_table_description();

        return $result["Data_free"];
    }

    public function getAutoIncrement()
    {
        $result = $this->__get_table_description();

        return $result["Auto_increment"];
    }

    public function setAutoIncrement($auto_increment)
    {
        $q = new __MysqlQuery("ALTER TABLE ".$this->my_table." AUTO_INCREMENT=".$auto_increment.";");
        $q->exec();

        $this->reload();
    }

    public function getCreateTime()
    {
        $result = $this->__get_table_description();

        return $result["Create_time"];
    }

    public function getUpdateTime()
    {
        $result = $this->__get_table_description();

        return $result["Update_time"];
    }

    public function getCheckTime()
    {
        $result = $this->__get_table_description();

        return $result["Check_time"];
    }

    public function getCollation()
    {
        $result = $this->__get_table_description();

        return $result["Collation"];
    }

    public function getChecksum()
    {
        $result = $this->__get_table_description();

        return $result["Checksum"];
    }

    public function getCreateOptions()
    {
        $result = $this->__get_table_description();

        return $result["Create_options"];
    }

    public function getComment()
    {
        $result = $this->__get_table_description();

        return $result["Comment"];
    }



}

?>