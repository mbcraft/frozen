<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class __MysqlSelect extends __AbstractMysql
{
    private $num_rows_result;

    private $group_by = null;
    private $order_by = null;
    private $order_ascending = true;
    
    function add($field_name)
    {
        $key_value = array("field" => $field_name);
        $this->fields[] = $key_value;
    }

    function count($field_name,$as_label)
    {
        $key_value = array("field" => "count(".$field_name.") AS ".$as_label);
        $this->fields[] = $key_value;
    }

    function addGrouping($field_name)
    {
        $this->group_by = $field_name;
    }

    function addOrdering($field_name,$ascending=true)
    {
        $this->order_by = $field_name;
        $this->order_ascending = $ascending;
    }



    private function __sql_auto_add_all()
    {
        if (sizeof($this->fields)==0)
            $this->add("*");
    }

    private function __sql_from_tables()
    {
        $this->sql.=" FROM `".$this->my_table."`";
    }

    private function __sql_group_by()
    {
        if ($this->group_by!==null)
        {
            $this->sql.=" GROUP BY ".$this->group_by;
        }
    }
    
    private function __sql_order_by()
    {
        if ($this->order_by!==null)
        {
            $this->sql.=" ORDER BY ".$this->order_by;
            if ($this->order_ascending==true)
                $this->sql.=" ASC";
            else
                $this->sql.=" DESC";
        }
    }

    function sql()
    {
        $this->__sql_auto_add_all();

        $this->sql ="SELECT ";

        $this->__sql_field_list(false);

        $this->__sql_from_tables();

        $this->__sql_conditions();

        //group by
        $this->__sql_group_by();

        //order
        $this->__sql_order_by();

        //limit
        $this->__sql_limit();

        $this->__sql_end();

        return $this->sql;
    }

    function exec()
    {
        if (!DB::isConnectionOpen()) Log::error(__METHOD__, "La connessione al database non e' aperta prima della query.");

        $result = mysql_query($this->sql());
        if ($result)
            $this->num_rows_result = mysql_num_rows($result);
        else
            $this->num_rows_result = 0;
        return $result;
    }

    function exec_fetch_assoc()
    {
        $result = $this->exec();

        $final_result = $this->__fetch_assoc($result);

        mysql_free_result($result); // -OK

        return $final_result;
    }

    function exec_fetch_assoc_all()
    {
        $result = $this->exec();

        $final_result = $this->__fetch_assoc_all($result);

        mysql_free_result($result); // -OK

        return $final_result;
    }

    function get_num_rows()
    {
        return $this->num_rows_result;
    }


/*
 * TODO : controllare bug mysql_free_result per query a singolo risultato
 */
}

?>