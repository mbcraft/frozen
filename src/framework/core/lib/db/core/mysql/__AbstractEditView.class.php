<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
abstract class __AbstractEditView
{
    private $sql;

    private $fields = array();
    private $joins = array();

    private $tables = array();

    private $exec_done = false;

    function __construct($op_type,$view_name)
    {
        $this->sql = $op_type." ALGORITHM = MERGE VIEW `".$view_name."` AS ";
    }

    function addJoinFields($source_table_name,$source_field_name,$target_table_name,$target_field_name=null)
    {
        if ($source_table_name==null)
            throw new InvalidParameterException("source_table_name non puo' essere nullo!!");
        if ($source_field_name==null)
            throw new InvalidParameterException("source_field_name non puo' essere nullo!!");
        if ($target_table_name==null)
            throw new InvalidParameterException("target_table_name non puo' essere nullo!!");

        if ($source_table_name==$target_table_name) throw new InvalidParameterException("Le tabelle di join devono essere distinte!!");
        if ($target_field_name==null) $target_field_name = $source_field_name;

        $this->joins[] = array("source_table_name" => $source_table_name,"source_field_name" => $source_field_name,
                               "target_table_name" => $target_table_name,"target_field_name" => $target_field_name);
        $this->tables[$source_table_name] = array();
        $this->tables[$target_table_name] = array();
    }

    function addViewField($table_name,$field_name,$view_field_name=null)
    {
        if ($table_name==null)
            throw new InvalidParameterException("table_name non puo' essere nullo!!");
        if ($field_name==null)
            throw new InvalidParameterException("field_name non puo' essere nullo!!");

        if ($view_field_name==null) $view_field_name = $field_name;
        $this->fields[$view_field_name] = array("table_name" => $table_name,"field_name" => $field_name);
        $this->tables[$table_name] = array();
    }

    public function exec()
    {
        if (!$this->exec_done)
        {
            $this->sql.="SELECT ";
            foreach ($this->fields as $field => $props)
                $this->sql.= "`".$props["table_name"]."`.`".$props["field_name"]."` AS `".$field."`,";

            //rimuovo l'ultima virgola
            $this->sql = substr($this->sql,0,strlen($this->sql)-1);

            $this->sql.=" FROM ";

            foreach ($this->tables as $table_name => $props)
                $this->sql.="`".$table_name."`,";

            //rimuovo l'ultima virgola
            $this->sql = substr($this->sql,0,strlen($this->sql)-1);

            $this->sql.=" WHERE ";

            foreach ($this->joins as $join)
                $this->sql.="(`".$join["source_table_name"]."`.`".$join["source_field_name"]."`=`".$join["target_table_name"]."`.`".$join["target_field_name"]."`) AND";

            //rimuovo l'ultimo AND
            $this->sql = substr($this->sql,0,strlen($this->sql)-4);

            $this->sql.=";";

            mysql_query($this->sql);
            $this->exec_done = true;
        }
    }
}

?>