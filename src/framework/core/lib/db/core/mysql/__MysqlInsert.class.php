<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class __MysqlInsert extends __AbstractMysql
{
    function add($field_name,$field_value,$quote=true)
    {
        $key_value = array("field" => $field_name,"value" => mysql_real_escape_string($field_value), "quote" => $quote);
        $this->fields[] = $key_value;
    }

    private function __sql_value_list()
    {
        $first = true;
        foreach ($this->fields as $kv)
        {
            if (!$first) $this->sql.=",";
            if ($kv["quote"]) $this->sql.="'";
            $this->sql.=$kv["value"];
            if ($kv["quote"]) $this->sql.="'";
            $first = false;
        }
    }

    function sql()
    {
        $this->sql ="INSERT INTO `".$this->my_table."` (";

        $this->__sql_field_list();

        $this->sql.=") VALUES (";

        $this->__sql_value_list();

        $this->sql.=")";

        $this->__sql_end();

        return $this->sql;
    }

    function exec()
    {
        if (!DB::isConnectionOpen()) $this->__error(__METHOD__, "La connessione al database non e' aperta prima della query con MysqlInsert");
        $result = mysql_query($this->sql());
        if (!$result) $this->__error(__METHOD__,"Errore nella query di insert : ".mysql_error());
        return $result;
    }

    function insert_id()
    {
        return mysql_insert_id();
    }

    function addFromPost($field_name,$quote=true)
    {
        if ($_POST[$field_name]===NULL)
            $field_value = "";
        else
            $field_value = $_POST[$field_name];
        $key_value = array("field" => $field_name,"value" => $field_value, "quote" => $quote);
        $this->fields[] = $key_value;
    }

}

/*
 *

 *
 */

?>