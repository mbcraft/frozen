<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class __MysqlTableFieldsDescription extends __AbstractMysql
{
    private $exec_done = false;

    private $data;
    
    private $num_rows_result;

    public function __sql_describe()
    {
        $this->sql = "DESCRIBE ".$this->my_table.";";
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

    protected function __get_table_fields_description()
    {
        if (!$this->exec_done)
        {
            $this->__sql_describe();
            $result = $this->exec();

            $this->data = $this->__fetch_assoc_all($result);

            if ($result!=false) mysql_free_result($result);

            $this->exec_done = true;
        }
        return $this->data;
    }

    /*
     * Ritorna un array di campi del tipo
     * [nome_campo] => [tipo]
     * */
    public function getAllFields()
    {
        $result = $this->__get_table_fields_description();

        $field_list = array();
        foreach ($result as $row)
        {
            $field_list[$row["Field"]]["type"]= $row["Type"];
        }

        return $field_list;
    }

    public function getPrimaryKeyFields()
    {
        $result = $this->__get_table_fields_description();
        $field_list = array();
        foreach ($result as $row)
        { 
            if ($row["Key"]=="PRI")
                $field_list[] = $row["Field"];
        }

        return $field_list;
    }

    public function hasField($field)
    {
        return array_key_exists($field, $this->getAllFields());
    }
}

?>