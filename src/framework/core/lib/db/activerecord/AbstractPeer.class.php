<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

abstract class AbstractPeer extends BasicObject implements InitializeAfterLoad
{
    const CHECK_PREFIX = "__check_";

    private static $__dump_sql=false;

    private $enable_call_recognition = true;

    private $fetchedAsProperties = array();

    protected function setup()
    {}

    public function __construct()
    {
        $this->enable_call_recognition = false;
        $this->setup();
        $this->enable_call_recognition = true;
    }
    
    public abstract function __getMyTable();

    protected function fetchAsProperties($field_name)
    {
        $this->fetchedAsProperties[$field_name] = array();
    }

    public static function __classLoaded($class_name)
    {
        ActiveRecord::init(self::__getStaticRawClassName($class_name));
    }

    public function __isLinked()
    {
        $database_description = DB::newDatabaseDescription();

        return $database_description->hasTable($this->__getMyTable());
    }

    public function __getAllFields()
    {
        $raw_class_name = $this->__getRawClassName();
        return ActiveRecord::$cachedAllFields[$raw_class_name];
    }

    public function __getPrimaryKeyFields()
    {
        $raw_class_name = $this->__getRawClassName();
        return ActiveRecord::$cachedPrimaryKeyFields[$raw_class_name];
    }

    private static function __getStaticRawClassName($class_name)
    {
        return substr($class_name,0,strlen($class_name)-4);
    }

    private function __getRawClassName()
    {
        $class_name = get_class($this);
        return self::__getStaticRawClassName($class_name);
    }

    private function __getDataObjectClassName()
    {
        return $this->__getRawClassName()."DO";
    }

    public static function __is_dump_sql()
    {
        return self::$__dump_sql;
    }

    public static function __dump_sql($true_or_false=true)
    {
        self::$__dump_sql = $true_or_false;
    }

    public function new_do()
    {
        return __create_instance($this->__getDataObjectClassName());
    }

    /*
     * Ricerca per chiave primaria. Prende in ingresso un numero arbitrario di valori, andando per ordine sulla chiave primaria.
     * I valori null vengono saltati.
     */
    public function find_by_id()
    {
        $args_list = func_get_args();
        $ss = DB::newSelect($this->__getMyTable());
        
        $primary_key_fields = $this->__getPrimaryKeyFields();

        $i = 0;
        foreach($args_list as $arg)
        {
            if ($arg!==null)
                $ss->addConditionEquals($primary_key_fields[$i],$arg);
            $i++;
        }

        $query_result = $ss->exec_fetch_assoc();

        //se non trovo l'oggetto con quell'id ritorno NULL
        if ($query_result===false)
            return null;
        else
            return $this->__load($query_result);
    }

    public function find_all()
    {
        $ss = DB::newSelect($this->__getMyTable());
        return $this->__load_into_objects($ss);
    }

    public function __sort_by__($method,$args)
    {
        $method = str_replace("sort_by_", "", $method);

        $field_and_ordering = explode("__", $method);
        $field = $field_and_ordering[0];
        $descending = $field_and_ordering[1] == "DESC" ? true : false;

        $array_data = $args[0];
        $ordered = false;
        while (!$ordered)
        {
            $ordered = true;
            for ($i=0;$i<count($array_data)-1;$i++)
            {
                $comp = strcasecmp($array_data[$i]->{$field},$array_data[$i+1]->{$field});
                if (($comp<0 && $descending) || ($comp>0 && !$descending))
                {
                    $swap = $array_data[$i];
                    $array_data[$i] = $array_data[$i+1];
                    $array_data[$i+1] = $swap;
                    $ordered = false;
                }
            }
        }
        return $array_data;

    }

    private $incremental_find_filters = array();

    private function field_needs_quotes($field)
    {
        $all_fields = $this->__getAllFields();

        $type = $all_fields[$field]["type"];

        if (StringUtils::ends_with($type,"text") || StringUtils::starts_with($type,"varchar") || StringUtils::starts_with($type,"date") || StringUtils::starts_with($type,"time") )
            return true;
        else
            return false;
    }

    private function __add_contains_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "contains" , "field" => $field, "value" => $args[0],"not" => false);
    }

    private function __add_begin_with_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "begin_with" , "field" => $field, "value" => $args[0] ,"not" => false);
    }

    private function __add_end_with_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "end_with" , "field" => $field, "value" => $args[0] ,"not" => false);
    }
    
    private function __add_dont_contains_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "contains" , "field" => $field, "value" => $args[0],"not" => true);
    }

    private function __add_dont_begin_with_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "begin_with" , "field" => $field, "value" => $args[0] ,"not" => true);
    }

    private function __add_dont_end_with_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "end_with" , "field" => $field, "value" => $args[0] ,"not" => true);
    }

    private function __add_equals_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "equals" , "field" => $field, "value" => $args[0]);
    }

    private function __add_not_equals_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "not_equals" , "field" => $field, "value" => $args[0]);
    }

    private function __add_greater_than_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "greater_than" , "field" => $field, "value" => $args[0],"quote" => $this->field_needs_quotes($field));
    }

    private function __add_greater_than_or_equal_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "greater_than_or_equal" , "field" => $field, "value" => $args[0],"quote" => $this->field_needs_quotes($field));
    }

    private function __add_less_than_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "less_than" , "field" => $field, "value" => $args[0],"quote" => $this->field_needs_quotes($field));
    }

    private function __add_less_than_or_equal_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "less_than_or_equal" , "field" => $field, "value" => $args[0],"quote" => $this->field_needs_quotes($field));
    }

    private function __add_in_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "in" , "field" => $field, "values" => $args[0],"quote" => $this->field_needs_quotes($field));
    }

    private function __add_not_in_filter($field,$args)
    {
        $this->incremental_find_filters[] = array("stage" => 1,"type"=> "not_in" , "field" => $field, "values" => $args[0],"quote" => $this->field_needs_quotes($field));
    }

    private function __add_ordering_filter($field,$order_ascending)
    {
        $this->incremental_find_filters[] = array("stage" => 2,"type"=> "order_by" , "field" => $field, "ascending" => $order_ascending);
    }

    private function __add_limit_filter($start_limit,$num)
    {
        $this->incremental_find_filters[] = array("stage" => 3,"type"=> "limit" , "start" => $start_limit, "count" => $num);
    }

    private function __add_grouping($field)
    {
        $this->incremental_find_filters[] = array("stage" => 2,"type" =>"group_by" , "field" => $field);
    }
/*
    private function __add_match_against_extended($fields,$value)
    {
        $this->incremental_find_filters[] = array("stage" => 1, "type" => "match_against", "fields" => $fields, "value" => $value ,"extended" => true);
    }

    private function __add_match_against($fields,$value)
    {
        $this->incremental_find_filters[] = array("stage" => 1, "type" => "match_against", "fields" => $fields, "value" => $value, "extended" => false);
    }
*/
    public function count($field_name)
    {
        $ss = DB::newSelect($this->__getMyTable());
        $ss->count($field_name,"final_count");

        $this->__apply_filters($ss);

        $result = $ss->exec_fetch_assoc();
        return $result["final_count"];
    }

    public function find()
    {
        $ss = DB::newSelect($this->__getMyTable());

        $this->__apply_filters($ss);

        return $this->__load_into_objects($ss);
    }
    
    public function find_single_result()
    {
        $ss = DB::newSelect($this->__getMyTable());

        $this->__apply_filters($ss);

        $result = $this->__load_into_objects($ss);
        
        if (count($result)==1)
            return $result[0];
        else
            throw new ActiveRecordException("Single result expected!!");
    }

    private function __apply_filters($ss)
    {
        foreach ($this->incremental_find_filters as $filter)
        {
            switch ($filter["type"])
            {
                //case "match_against" : $ss->addConditionMatchAgainst($filter["fields"],$filter["value"],$filter["extended"]);break;
                case "in" : $ss->addConditionIn($filter["field"],$filter["values"],$filter["quote"]);break;
                case "not_in" : $ss->addConditionNotIn($filter["field"],$filter["values"],$filter["quote"]);break;
                case "equals" : $ss->addConditionEquals($filter["field"],$filter["value"]);break;
                case "not_equals" : $ss->addConditionNotEquals($filter["field"],$filter["value"]);break;
                case "contains" : $ss->addConditionContains($filter["field"],$filter["value"],$filter["not"]); break;
                case "begin_with" : $ss->addConditionBeginWith($filter["field"],$filter["value"],$filter["not"]); break;
                case "end_with" : $ss->addConditionEndWith($filter["field"],$filter["value"],$filter["not"]); break;
                case "greater_than" : $ss->addConditionGreaterThan($filter["field"],$filter["value"],$filter["quote"]);break;
                case "greater_than_or_equal" : $ss->addConditionGreaterThanOrEqual($filter["field"],$filter["value"],$filter["quote"]);break;
                case "less_than" : $ss->addConditionLessThan($filter["field"],$filter["value"],$filter["quote"]);break;
                case "less_than_or_equal" : $ss->addConditionLessThanOrEqual($filter["field"],$filter["value"],$filter["quote"]);break;

            }

        }

        foreach ($this->incremental_find_filters as $filter)
        {
            if ($filter["type"] == "group_by")
            {
                $ss->addGrouping($filter["field"]);
                $ss->add($filter["field"]);
            }
        }

        foreach ($this->incremental_find_filters as $filter)
        {
            if ($filter["type"] == "order_by")
            {
                $ss->addOrdering($filter["field"],$filter["ascending"]);
            }
        }

        foreach ($this->incremental_find_filters as $filter)
        {
            if ($filter["type"]=="limit")
            {
                $ss->set_limit($filter["start"],$filter["count"]);
            }
        }
    }



    private function __parse_incremental_find($method,$args)
    {
        $tokens = explode("__",$method);
        $field = $tokens[0];
        $filter = $tokens[1];
        //aggiungere qui il controllo di più tokens per MATCH_AGAINST
        //$fields = array_slice($tokens, ...);
        switch($filter)
        {
            case "LIKE" : return $this->__add_contains_filter($field,$args);
            case "CONTAINS" : return $this->__add_contains_filter($field,$args);
            case "DONT_CONTAINS" : return $this->__add_dont_contains_filter($field,$args);
            case "BEGIN_WITH" : return $this->__add_begin_with_filter($field,$args);
            case "DONT_BEGIN_WITH" : return $this->__add_dont_begin_with_filter($field,$args);
            case "END_WITH" : return $this->__add_end_with_filter($field,$args);
            case "DONT_END_WITH" : return $this->__add_dont_end_with_filter($field,$args);

            case "EQUAL" : return $this->__add_equals_filter($field,$args);
            case "EQUALS" : return $this->__add_equals_filter($field,$args); //deprecated -- issue warning
            case "NOT_EQUAL" : return $this->__add_not_equals_filter($field,$args);
            case "NOT_EQUALS" : return $this->__add_not_equals_filter($field,$args); //deprecated -- issue warning
            case "GREATER_THAN" : return $this->__add_greater_than_filter($field, $args);
            case "GREATER_THAN_OR_EQUAL" : return $this->__add_greater_than_or_equal_filter($field, $args);
            case "LESS_THAN" : return $this->__add_less_than_filter($field, $args);
            case "LESS_THAN_OR_EQUAL" : return $this->__add_less_than_or_equal_filter($field, $args);

            case "IN" : return $this->__add_in_filter($field,$args);
            case "NOT_IN" : return $this->__add_not_in_filter($field,$args);

            case "GROUP_BY" : return $this->__add_grouping($args[0]);
            case "ORDER_ASCENDING" : return $this->__add_ordering_filter($field,true);
            case "ORDER_DESCENDING" : return $this->__add_ordering_filter($field,false);
            case "PAGE" : return $this->__add_limit_filter(($args[0]-1)*$args[1], $args[1]);
        }
    }

    /*
     * Trova un array di elementi in base alla query utilizzata.
     */
    public function __find_all_by__($method,$args)
    {
        $original_method = $method;
        $method = str_replace("find_all_by_", "", $method);
        $field_list = explode("_AND_", $method);

        if (count($args) != count($field_list)) $this->__error(__METHOD__,"Il numero dei campi non corrisponde : $original_method");
        $table = $this->__getMyTable();
        $raw_class_name = $this->__getRawClassName();
        $ss = DB::newSelect($table);
        $i = 0;
        foreach ($field_list as $field)
        {
            if (!ActiveRecord::has_field_for_class($raw_class_name,$field )) throw new Exception("Il campo '$field' non e' presente nella tabella '$table', raw class name ".$raw_class_name." :".ActiveRecord::print_fields_for_class($raw_class_name)." - ".ActiveRecord::print_tables());
            $ss->addConditionEquals($field,$args[$i]);
            $i++;
        }

        return $this->__load_into_objects($ss);
    }

    private function __load_into_objects($select)
    {
        $result_array = $select->exec_fetch_assoc_all();
        $real_result = array();
        foreach ($result_array as $single_result)
        {
            $real_result[] = $this->__load($single_result);

        }
        return $real_result;
    }

    public function __call($method,$args)
    {
        if (!$this->enable_call_recognition)
            throw new Exception("Il metodo ".$method." non è stato trovato nella classe.");

        if (preg_match("/^find_all_by_/", $method)) return $this->__find_all_by__($method,$args);
        if (preg_match("/^sort_by_/", $method)) return $this->__sort_by__($method,$args);
        return $this->__parse_incremental_find($method,$args);
        return parent::__call($method,$args);
    }

    /*
     * Salvo l'oggetto. Se è nuovo viene inserito, altrimenti viene aggiornato.
     * Se l'oggetto viene inserito viene salvata al suo interno l'id di inserimento per campi con auto-increment.
     * Se l'oggetto viene modificato vengono aggiornati solo i campi modificati.
     */

    public function save($do)
    {
        if ($do==null || !$do instanceof AbstractDO)
            throw new InvalidParameterException("L'oggetto non è un DO valido.");

        $pks = $this->__getPrimaryKeyFields();
        $all_fields = $this->__getAllFields();

        if ($do->__isNew())
        {
            $xx = DB::newInsert($this->__getMyTable());
            $insert = true;
        }
        else
        {

            if (!$do->__isChanged())
            {
                return;
            }

            $xx = DB::newUpdate($this->__getMyTable());
            foreach ($pks as $field)    //imposto i primary key fields
                $xx->addConditionEquals($field,$do->{$field});
            $insert = false;

        }
        if ($insert)    //insert
        {
            //echo "Doing insert ...";
            $field_list = $do->__get_fields();
            foreach ($field_list as $key => $value)
            {
                $saved = false;
                if (isset($this->fetchedAsProperties[$key]))
                {
                    $xx->add($key,PropertiesUtils::saveToString($value,false));
                    $saved = true;
                }

                if (!$saved)
                {
                    //prevedere l'utilizzo di addBoolean + test
                    $xx->add($key,$value);
                }
            }

            if (isset($all_fields["dataora_creazione"]))
                $xx->addNow("dataora_creazione");
        }
        else    //update
        {
            //echo "Doing update ...";
            $field_list = $do->__getChangedFields();
            foreach ($field_list as $key)
            {
                $saved = false;
                if (isset($this->fetchedAsProperties[$key]))
                {
                    $xx->add($key,PropertiesUtils::saveToString($do->{$key},false));
                    $saved = true;
                }

                if (!$saved)
                {
                    //prevedere l'utilizzo di addBoolean + test
                    $xx->add($key,$do->{$key});
                }
            }
        }

        if (isset($all_fields["dataora_ultima_modifica"]))
            $xx->addNow("dataora_ultima_modifica");

        $xx->exec();

        //se posso salvo l'id nella chiave primaria.
        if ($do->__isNew() && count($pks)==1)
        {
            
            $insert_id = $xx->insert_id();
            $do->{$pks[0]} = $insert_id;
        }
        
        $do->__markAsSaved();
    }

    /*
     * Salvo tutti gli oggetti presenti nell'array
     */
    public function save_all($arr)
    {
        foreach ($arr as $do)
            $this->save($do);
    }

    /*
     * Elimino tutti gli oggetti che fanno match con le parti di chiave primaria diverse da null.
     */
    public function delete($do)
    {
        $dd = DB::newDelete($this->__getMyTable());
        $primary_key_fields = $this->__getPrimaryKeyFields();
        foreach ($primary_key_fields as $field)
        {
            if ($do->{$field} !== null)
                $dd->addConditionEquals($field,$do->{$field});
        }
        $dd->exec();
        $do->__markAsDeleted();
    }

    public function delete_by_id($id)
    {
        $primary_key_fields = $this->__getPrimaryKeyFields();
        if (sizeof($primary_key_fields)==1)
        {
            if ($id !== null)
            {
                $dd = DB::newDelete($this->__getMyTable());

                $dd->addConditionEquals($primary_key_fields[0],$id);
                
                $dd->exec();
            }
        }
        
    }

    /*
     * Elimino tutti gli oggetti presenti nell'array.
     */
    public function delete_all($arr)
    {
        foreach ($arr as $do)
        {
            $this->delete($do);
        }
    }

    public function delete_all_by_id($arr)
    {
        foreach ($arr as $elem_id)
        {
            $this->delete_by_id($elem_id);
        }
    }

    /*
     * Utilizzo tutti i vari fetcher per leggere i dati dal DO e salvarli per la query.
     * */
    private function __load($query_result)
    {
        $all_fields = $this->__getAllFields();

        if (!is_array($query_result)) throw new ErrorException("L'oggetto da caricare non è un array");
        $do = $this->__create_instance($this->__getDataObjectClassName());
        $do->__markAsNotNew();
        $do->__setLoadingState(true);

        foreach ($query_result as $key => $value)
        {
            $saved = false;
            if (isset($this->fetchedAsProperties[$key]))
            {
                $do->{$key} = PropertiesUtils::readFromString($value,false);  
                $saved = true;
            }

            if (isset($this->fetchedAsEntity[$key]))
            {
                $entity_peer = $this->fetchedAsEntity[$key]["peer_class_name"];
                $entity = $entity_peer->find_by_id($value);
                $entity_field_name = $this->fetchedAsEntity[$key]["entity_name"];
                $do->{$entity_field_name} = $entity;
                $saved = true;
            }

            //if (!isset(Config::instance()->DB_KEEP_AMERICAN_DATES) || !Config::instance()->DB_KEEP_AMERICAN_DATES)
            //{
                if ($all_fields[$key]["type"]=="date")
                {
                    $do->{$key} = DateTimeUtils::reverse_date_yyyy_mm_dd($value);
                    $saved = true;
                }
            //}

            //aggiungere datetime e time

            if (!$saved)
            {
                $do->{$key} = $value;
            }
        }
        $do->__setLoadingState(false);
        return $do;
    }

    private function __create_instance($classname,$arguments=null)
    {
        $export = __flat_export($arguments);
        $eval_string = "return new $classname($export);";
        return eval($eval_string);
    }

    public function updateWithMap($params)
    {        
        $pk_fields = $this->__getPrimaryKeyFields();
        $all_fields = $this->__getAllFields();
        $do = $this->find_by_id(Params::get($pk_fields[0]));
        foreach ($params as $key => $value)
        {
            $saved = false;
            if ($all_fields[$key]["type"]=="date")
            {
                $do->{$key} = DateTimeUtils::reverse_date_dd_mm_yyyy($value);
                $saved = true;
            }

            if (!$saved)
                $do->{$key} = $value;
        }

        return $do;
    }

    public function setupWithMap($do,$params)
    {
        $all_fields = $this->__getAllFields();

        foreach ($params as $key => $value)
        {
            $saved = false;
            if ($all_fields[$key]["type"]=="date")
            {
                $do->{$key} = DateTimeUtils::reverse_date_dd_mm_yyyy($value);
                $saved = true;
            }

            if (!$saved)
                $do->{$key} = $value;
        }

        return $do;
    }

    /*
     * Utilizzato per aggiornare un DO preso per chiave.
     * */
    public function updateByParams()
    {
        $fields = $this->__getAllFields();
        $pk_fields = $this->__getPrimaryKeyFields();

        $params_list = array();

        //tolgo le chiavi primarie
        foreach (ArrayUtils::delete_keys($fields,$pk_fields) as $fkey => $attribs)
        {
            if (Params::is_set($fkey))
            {
                $params_list[$fkey] = Params::get($fkey);
            }
        }

        foreach (Params::keys() as $k)
        {
            if (StringUtils::starts_with($k,self::CHECK_PREFIX))
            {
                $field_to_check = substr($k,strlen(self::CHECK_PREFIX));
                if (Params::is_set($field_to_check))
                {
                    $params_list[$field_to_check] = true;
                }
                else
                {
                    $params_list[$field_to_check] = false;
                }
            }
        }

        return $this->updateWithMap($params_list);
    }

    /*
     * Utilizzato per configurare un DO già presente.
     * */
    public function setupByParams($do)
    {
        $fields = $this->__getAllFields();
        $pk_fields = $this->__getPrimaryKeyFields();

        $params_list = array();

        //tolgo le chiavi primarie
        foreach (ArrayUtils::delete_keys($fields,$pk_fields) as $fkey => $attribs)
        {
            if (Params::is_set($fkey))
            {
                $params_list[$fkey] = Params::get($fkey);

            }
        }

        foreach (Params::keys() as $k)
        {
            if (StringUtils::starts_with($k,self::CHECK_PREFIX))
            {
                $field_to_check = substr($k,strlen(self::CHECK_PREFIX));
                if (Params::is_set($field_to_check))
                {
                    $params_list[$field_to_check] = true;
                }
                else
                {
                    $params_list[$field_to_check] = false;
                }
            }
        }

        return $this->setupWithMap($do,$params_list);
    }

}

?>