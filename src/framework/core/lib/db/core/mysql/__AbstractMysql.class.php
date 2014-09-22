<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

abstract class __AbstractMysql
{
    const CONDITION_TYPE_EQUALS = "equals";
    const CONDITION_TYPE_NOT_EQUALS = "not_equals";
    const CONDITION_TYPE_LESS_THAN = "less_than";
    const CONDITION_TYPE_LESS_THAN_OR_EQUAL = "less_than_or_equal";
    const CONDITION_TYPE_GREATER_THAN = "greater_than";
    const CONDITION_TYPE_GREATER_THAN_OR_EQUAL = "greater_than_or_equal";
    const CONDITION_MATCH_AGAINST = "match_against";
    const CONDITION_TYPE_IN = "in";
    const CONDITION_TYPE_NOT_IN = "not_in";
    const CONDITION_BEGIN_WITH = "begin_with";
    const CONDITION_CONTAINS = "contains";
    const CONDITION_END_WITH = "end_with";
    const CONDITION_REGEXP = "regexp";

    protected $my_table;

    protected $fields = array();
    protected $conditions = array();

    protected $sql="";
    
    protected $from_limit = NULL;
    protected $limit_count = NULL;

    public function __construct($my_table)
    {
        if ($my_table==null || strlen($my_table)<3)
            throw new InvalidParameterException("La tabella e' nulla o di lunghezza troppo breve : ".$my_table);
        $this->my_table = $my_table;
    }

    public function __getFields()
    {
        return $this->fields;
    }

    public function __getConditions()
    {
        return $this->conditions;
    }

    function addConditionRegexp($field,$value,$not = false,$binary = false)
    {
        $key_value = array("field" => $field,"value" => $value , "not" => $not, "binary" => $binary, "quote" => true, "type" => self::CONDITION_REGEXP);
        $this->conditions[] = $key_value;
    }

    function addConditionContains($field,$value,$not = false)
    {
        $key_value = array("field" => $field,"value" => $value , "not" => $not, "quote" => true, "type" => self::CONDITION_CONTAINS);
        $this->conditions[] = $key_value;
    }

    function addConditionBeginWith($field,$value,$not = false)
    {
        $key_value = array("field" => $field,"value" => $value , "not" => $not, "quote" => true, "type" => self::CONDITION_BEGIN_WITH);
        $this->conditions[] = $key_value;
    }

    function addConditionEndWith($field,$value,$not = false)
    {
        $key_value = array("field" => $field,"value" => $value , "not" => $not, "quote" => true, "type" => self::CONDITION_END_WITH);
        $this->conditions[] = $key_value;
    }

    function addConditionMatchAgainst($fields,$query,$extended=false)
    {
        $key_value = array("fields" => $fields,"query" => $query , "extended" => $extended, "type" => self::CONDITION_MATCH_AGAINST);
        $this->conditions[] = $key_value;
    }

    function addConditionGreaterThan($field_name,$field_value)
    {
        $key_value = array("field" => $field_name,"value" => $field_value, "quote" => false, "type" => self::CONDITION_TYPE_GREATER_THAN, "inner_statement" => false);
        $this->conditions[] = $key_value;
    }

    function addConditionGreaterThanOrEqual($field_name,$field_value,$quote=false)
    {
        $key_value = array("field" => $field_name,"value" => $field_value, "quote" => $quote, "type" => self::CONDITION_TYPE_GREATER_THAN_OR_EQUAL, "inner_statement" => false);
        $this->conditions[] = $key_value;
    }

    function addConditionLessThan($field_name,$field_value,$quote=false)
    {
        $key_value = array("field" => $field_name,"value" => $field_value, "quote" => $quote, "type" => self::CONDITION_TYPE_LESS_THAN, "inner_statement" => false);
        $this->conditions[] = $key_value;
    }

    function addConditionLessThanOrEqual($field_name,$field_value,$quote)
    {
        $key_value = array("field" => $field_name,"value" => $field_value, "quote" => $quote, "type" => self::CONDITION_TYPE_LESS_THAN_OR_EQUAL, "inner_statement" => false);
        $this->conditions[] = $key_value;
    }

    function addConditionIn($field_name,$values,$quote=false)
    {
        $key_value = array("field" => $field_name,"values" => $values, "quote" => $quote, "type" => self::CONDITION_TYPE_IN, "inner_statement" => false);
        $this->conditions[] = $key_value;
    }

    function addConditionNotIn($field_name,$values,$quote=false)
    {
        $key_value = array("field" => $field_name,"values" => $values, "quote" => $quote, "type" => self::CONDITION_TYPE_NOT_IN, "inner_statement" => false);
        $this->conditions[] = $key_value;
    }

    function addConditionEquals($field_name,$field_value,$quote=true,$inner_statement=false)
    {
        if ($inner_statement)
            $field_value_string = $field_value;
        else
        {
            if ($field_value===true)
            {
                $field_value="true";
                $quote = false;
            }
            if ($field_value===false)
            {
                $field_value="false";
                $quote = false;
            }
            $field_value_string = mysql_real_escape_string($field_value);
        }
        $key_value = array("field" => $field_name,"value" => $field_value_string, "quote" => $quote, "type" => self::CONDITION_TYPE_EQUALS, "inner_statement" => $inner_statement);
        $this->conditions[] = $key_value;
    }

    function addConditionNotEquals($field_name,$field_value,$quote=true,$inner_statement=false)
    {
        if ($inner_statement)
            $field_value_string = $field_value;
        else
        {
            if ($field_value===true)
            {
                $field_value="true";
                $quote = false;
            }
            if ($field_value===false)
            {
                $field_value="false";
                $quote = false;
            }
            $field_value_string = mysql_real_escape_string($field_value);
        }
        $key_value = array("field" => $field_name,"value" => $field_value_string , "quote" => $quote, "type" => self::CONDITION_TYPE_NOT_EQUALS , "inner_statement" => $inner_statement);
        $this->conditions[] = $key_value;
    }

    function c_add($params_array)
    {
        foreach($params_array as $key => $value)
            $this->add($key,$value);
    }

    function c_addZero($params_array)
    {
        foreach($params_array as $key)
            $this->add($key,"0");
    }

    function addTrue($field)
    {
        $this->add($field,"true",false);
    }

    function addFalse($field)
    {
        $this->add($field,"false",false);
    }

    function addBoolean($field,$value)
    {
        if ($value)
            $this->addTrue($field);
        else
            $this->addFalse($field);
    }

    function addNow($field)
    {
       $this->add($field,"NOW()",false);
    }

    function c_addConditionEquals($params_array)
    {
        foreach($params_array as $key => $value)
            $this->addConditionEquals($key,$value);
    }

    function c_addConditionNotEquals($params_array)
    {
        foreach($params_array as $key => $value)
            $this->addConditionNotEquals($key,$value);
    }
    
    function set_limit($from=0,$count=NULL)
    {
        $this->from_limit = $from;
        $this->limit_count = $count;
    }

    protected function __sql_limit()
    {
        if ($this->from_limit!==NULL)
        {
            $this->sql.=" LIMIT ".$this->from_limit;
            if ($this->limit_count!==NULL)
                $this->sql.= ",".$this->limit_count;
        }
    }

    protected function __sql_field_match_against($kv)
    {
        $this->sql.=" MATCH(";

        $first = true;
        foreach($kv["fields"] as $fld)
        {
           if ($first==false) $this->sql.=",";
           $this->sql.="`".$fld."`";
           $first = false;
        }

        $this->sql.=")";
        $this->sql.=" AGAINST ('";
        $this->sql.=$kv["query"];
        $this->sql.="' ";
        if (isset($kv["extended"]) && $kv["extended"])
            $this->sql.="WITH QUERY EXPANSION";
        $this->sql.=") ";
    }

    protected function __sql_conditions()
    {
        $first = true;
        foreach ($this->conditions as $kv)
        {
            if ($first) $this->sql.=" WHERE ";
            else
            $this->sql.=" AND ";

            if ($kv["type"]==self::CONDITION_MATCH_AGAINST)
            {
                $this->__sql_field_match_against($kv);
            }
            else
            {

                $this->sql.="`".$kv["field"]."`";

                if ($kv["inner_statement"])
                {
                    $this->sql.=" IN ";
                }
                else
                {
                    if ($kv["type"]==self::CONDITION_CONTAINS || $kv["type"]==self::CONDITION_BEGIN_WITH || $kv["type"]==self::CONDITION_END_WITH)
                    {
                        if ($kv["not"])
                            $this->sql.=" NOT";
                        $this->sql.=" LIKE ";
                    }
                    if ($kv["type"]==self::CONDITION_REGEXP)
                    {
                        if ($kv["not"])
                            $this->sql.=" NOT";
                        $this->sql.=" REGEXP ";
                        if ($kv["binary"])
                            $this->sql.="BINARY ";
                    }
                    if ($kv["type"]==self::CONDITION_TYPE_EQUALS)
                        $this->sql.=" = ";
                    if ($kv["type"]==self::CONDITION_TYPE_NOT_EQUALS)
                        $this->sql.=" != ";
                    if ($kv["type"]==self::CONDITION_TYPE_GREATER_THAN)
                        $this->sql.=" > ";
                    if ($kv["type"]==self::CONDITION_TYPE_GREATER_THAN_OR_EQUAL)
                        $this->sql.=" >= ";
                    if ($kv["type"]==self::CONDITION_TYPE_LESS_THAN)
                        $this->sql.=" < ";
                    if ($kv["type"]==self::CONDITION_TYPE_LESS_THAN_OR_EQUAL)
                        $this->sql.=" <= ";
                    if ($kv["type"]==self::CONDITION_TYPE_IN)
                        $this->sql.=" IN ";
                    if ($kv["type"]==self::CONDITION_TYPE_NOT_IN)
                        $this->sql.=" NOT IN ";
                }


                if ($kv["inner_statement"]) $this->sql.="(";
                if ($kv["quote"]) $this->sql.="'";
                if ($kv["type"] == self::CONDITION_TYPE_IN || $kv["type"] == self::CONDITION_TYPE_NOT_IN)
                {
                    $this->sql.= " (".ArrayUtils::join($kv["values"], ",").")";
                }
                else
                {
                    if ($kv["type"] == self::CONDITION_BEGIN_WITH || $kv["type"]==self::CONDITION_CONTAINS)
                        $this->sql.="%";
                    $this->sql.=$kv["value"];
                    if ($kv["type"]==self::CONDITION_CONTAINS || $kv["type"]==self::CONDITION_END_WITH)
                        $this->sql.="%";

                }
                if ($kv["quote"]) $this->sql.="'";
                if ($kv["inner_statement"]) $this->sql.=")";

            }

            $first = false;
        }
    }

    protected function __sql_field_list($use_escape=true)
    {
        $first = true;
        foreach ($this->fields as $kv)
        {
            if (!$first) $this->sql.=",";
            if ($use_escape) $this->sql.="`";
            $this->sql.=$kv["field"];
            if ($use_escape) $this->sql.="`";
            $first = false;
        }
    }

    protected function __sql_end()
    {
        $this->sql.=" ;";
        if (AbstractPeer::__is_dump_sql())
            echo $this->sql;
    }

    protected function __fetch_assoc_all($result)
    {
        $arr = array();
        if ($result!=false)
        while ($row = mysql_fetch_assoc($result))
        {
            $arr[] = $row;
        }
        return $arr;
    }

    protected function __fetch_assoc($result)
    {
        if ($result!=false)
            return mysql_fetch_assoc($this->exec());
        else
            return array();
    }

}

?>