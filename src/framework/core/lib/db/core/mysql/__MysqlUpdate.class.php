<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class __MysqlUpdate extends __AbstractMysql
{

    function addFromPost($field_name,$quote=true)
    {
        if ($_POST[$field_name]===NULL)
            $field_value = "";
        else
            $field_value = $_POST[$field_name];

        $key_value = array("field" => $field_name,"value" => $field_value, "quote" => $quote);
        $this->fields[] = $key_value;
    }

    function add($field_name,$field_value,$quote=true)
    {
        $key_value = array("field" => $field_name,"value" => mysql_real_escape_string($field_value), "quote" => $quote);
        $this->fields[] = $key_value;
    }

    private function __sql_field_value_list()
    {
        $first = true;
        foreach ($this->fields as $kv)
        {
            if (!$first) $this->sql.=",";
            $this->sql.="`".$kv["field"]."`=";
            if ($kv["quote"]) $this->sql.="'";
            $this->sql.=$kv["value"];
            if ($kv["quote"]) $this->sql.="'";
            $first = false;
        }
    }

    function sql()
    {
        $this->sql ="UPDATE `".$this->my_table."` SET ";
        
        $this->__sql_field_value_list();

        $this->__sql_conditions();

        $this->__sql_limit();

        $this->__sql_end();

        return $this->sql;
    }

    function exec()
    {
        if (!DB::isConnectionOpen()) Log::error(__METHOD__, "La connessione al database non e' aperta prima della query con MysqlUpdate");

        return mysql_query($this->sql());
    }

}


?>