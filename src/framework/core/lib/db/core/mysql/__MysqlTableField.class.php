<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class __MysqlTableField
{
    const FIELD_DELIMITER = "`";

    private $name;
    private $optional;
    private $spec;
    private $comment;
    private $position;

    function __construct($name,$optional,$spec,$comment=null,$position=null)
    {
        $this->name = $name;
        $this->optional = $optional;
        $this->spec = $spec;
        $this->comment = $comment;
        $this->position = $position;
    }

    function render()
    {
        $my_spec = $this->spec;

        //replace field names
        $my_spec = str_replace("*field_name*",self::FIELD_DELIMITER.$this->name.self::FIELD_DELIMITER,$my_spec);
        $my_spec = str_replace("*unique_field_name*",self::FIELD_DELIMITER."unique_".$this->name.self::FIELD_DELIMITER,$my_spec);
        $my_spec = str_replace("*fulltext_field_name*",self::FIELD_DELIMITER."fulltext_".$this->name.self::FIELD_DELIMITER,$my_spec);
        $my_spec = str_replace("*index_field_name*",self::FIELD_DELIMITER."index_".$this->name.self::FIELD_DELIMITER,$my_spec);


        $nullable_string = $this->optional ? "NULL" : "NOT NULL";
        $my_spec = str_replace("*null*",$nullable_string,$my_spec);

        if ($this->comment==null)
            $my_spec = str_replace("*comment*","",$my_spec);
        else
        {
            $this->comment = str_replace("'","''",$this->comment);
            $my_spec = str_replace("*comment*","COMMENT '".$this->comment."'",$my_spec);
        }

        $position_def = $this->position;

        $my_spec = str_replace("*position*",$position_def,$my_spec);

        return $my_spec;
    }
}

?>