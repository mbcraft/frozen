<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class __MysqlCreateTable
{
    protected $my_table;
    protected $if_not_exists = false;
    protected $comment = null;
    protected $engine = null;
    protected $default_character_set = "utf8";

    protected $table_fields = array();

    protected $sql = "";


    public function __construct($my_table,$comment = null)
    {
        $this->my_table = $my_table;
        $this->comment = $comment;
    }

    public function getFieldFactory()
    {
        return __MysqlTableFieldFactory::instance();
    }

    public function add_column($field)
    {
        $this->table_fields[] = $field;
    }

    public function setIfNotExists($if_not_exists)
    {
        $this->if_not_exists = $if_not_exists;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    public function setDefaultCharacterSet($default_character_set)
    {
        $this->default_character_set = $default_character_set;
    }

    public function exec()
    {
        $this->sql.="CREATE TABLE ";

        if ($this->if_not_exists)
            $this->sql.="IF NOT EXISTS ";

        $this->sql.=$this->my_table." (";

        foreach ($this->table_fields as $field)
            $this->sql.=$field->render()." ,";

        $this->sql = substr($this->sql,0,strlen($this->sql)-2);

        $this->sql.=")";
        if ($this->engine==null) $this->engine = MysqlEngines::MYISAM;
        if ($this->engine!=null)
            $this->sql.="ENGINE = ".$this->engine." ";

        if ($this->default_character_set!=null)
            $this->sql.="DEFAULT CHARACTER SET ".$this->default_character_set." ";

        if ($this->comment!=null)
            $this->sql.="COMMENT = '".$this->comment."' ";

        $this->sql.=";";

        $result = mysql_query($this->sql);
        mysql_query("FLUSH TABLES;");
        return $result;
    }
}

?>