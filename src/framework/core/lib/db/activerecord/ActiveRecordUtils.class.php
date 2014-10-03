<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class ActiveRecordUtils
{
    const FILTER_PREFIX = "__filter_";
    const ORDER_BY_KEY = "__order_by";
    const ORDERING_KEY = "__ordering";

    const GROUP_BY_KEY = "__group_by";
    const PAGE_SIZE_KEY = "__page_size";
    const PAGE_NUM_KEY = "__page_num";

    const DEBUG_DUMP_SQL = "___debug_dump_sql";
       

    
    public static function fromArrayDOToDO($array)
    {
        if (array_key_exists(AbstractDO::CLASS_FIELD_KEY, $array))
        {
            $raw_class_name = $array[AbstractDO::CLASS_FIELD_KEY];
            $do = __create_instance($raw_class_name."DO");
            $do->__fromArray($array);
            return $do;
        }
        else
            throw new ActiveRecordException("Impossibile caricare oggetto dall'array.");
    }
    
    public static function isValidDO($do)
    {
        return $do!==null && $do instanceof AbstractDO;
    }
    
    public static function toArrayDOFromDO($do)
    {
        if ($do instanceof AbstractDO)
        {
            return $do->__toArray();
        }
        else
            throw new ActiveRecordException("Impossibile salvare il dataobject in un array.");
    }
    
    public static function isValidArrayDO($array)
    {
        return $array!==null && is_array($array) && array_key_exists(AbstractDO::CLASS_FIELD_KEY, $array);
    }  
    
    /*
     * Trasforma un generico albero di data object (prevedendo anche futuri campi che mappano associazioni)
     * in array.
     */
    
    public static function toArray($data)
    {
        if (self::isValidDO($data))
            return self::toArrayDOFromDO($data);
        else
            if (is_array($data))
            {
                $result = array();
                if (array_key_exists(0, $data))  // [0], [1], ...
                {
                    foreach ($data as $do)
                        $result[] = self::toArray($do);
                }
                else    //k => v 
                {
                    foreach ($data as $k => $v)
                        $result[$k] = self::toArray ($v);
                }
                return $result;
            }
        //casi non previsti : eccezione
        throw new ActiveRecordException("Impossibile effettuare la conversione in Array");
    }
    /*
     * Mappa una lista di DO in dati array. Prevede la possibilita' di liste annidate di DO.
     */
    public static function toDO($data)
    {
        if (self::isValidArrayDO($data))
            return self::fromArrayDOToDO ($data);
                else
                    if (is_array($data))
                    {
                        $result = array();
                        if (array_key_exists(0, $data))  // [0], [1], ...
                        {
                            foreach ($data as $do)
                                $result[] = self::toDO ($do);
                        }
                        else    //k => v 
                        {
                            foreach ($data as $k => $v)
                                $result[$k] = self::toDO ($v);
                        }
                        return $result;
                    }
        throw new ActiveRecordException("Impossibile effettuare la conversione!!");
    }
    
    public static function updateFilters($peer)
    {
        self::updateResultFilters($peer);
        self::updateGroupByFilters($peer);
        self::updatePageFilters($peer);
        self::updateOrderingFilters($peer);

        if (Params::is_set(self::DEBUG_DUMP_SQL))
            $peer->__dump_sql(true);
    }
    
    private static function isFilter($key,$value)
    {
        return strpos($key, self::FILTER_PREFIX)===0 && ($value!=="");
    }

    /*
     * __filter_titolo__EQUALS => titolo__EQUALS
     * */
    private static function getFilterCall($key)
    {
        if (strpos($key,self::FILTER_PREFIX)!==0) throw new ActiveRecordException("The key is not a valid filter key : ".$key);

        return substr($key,strlen(self::FILTER_PREFIX));
    }

    private static function getFilterField($key)
    {
        $field_with_selector = str_replace(self::FILTER_PREFIX,"",$key);

        $tokens = explode("__",$field_with_selector);

        return $tokens[0];
    }
    
    /*
     * Aggiorna i risultati del peer includendo eventuali ordinamenti.
     * __order_by => "titolo"
     * __ordering => "ORDER_ASCENDING" / "ORDER_DESCENDING"
     *
     *
     */
    public static function updateOrderingFilters($peer)
    {
        if (Params::is_set(self::ORDER_BY_KEY) && Params::is_set(self::ORDERING_KEY))
        {
            $order_by = Params::get(self::ORDER_BY_KEY);
            $ordering = Params::get(self::ORDERING_KEY);

            if ($order_by!="" && $ordering!="")
            {
                $call_name = $order_by."__".$ordering;
                $peer->{$call_name}();
            }
        }
    }
     
    private static function isDateReversingEnabled()
    {
        return !isset(Config::instance()->DB_KEEP_AMERICAN_DATES) || !Config::instance()->DB_KEEP_AMERICAN_DATES;
    }
    /*
     * Aggiorna i risultati del peer includendo eventuali filtri. (sarà da perfezionare ...)
     *
     * __filter_titolo__EQUALS
     */
    public static function updateResultFilters($peer)
    {
        $all_fields = $peer->__getAllFields();

        foreach (Params::keys() as $key)
        {

            if (self::isFilter($key,Params::get($key)))
            {
                $value = Params::get($key);

                $filter_call = self::getFilterCall($key);

                if (self::isDateReversingEnabled())
                {
                    if ($all_fields[self::getFilterField($key)]["type"]=="date")
                    {
                        $value = DateTimeUtils::reverse_date_dd_mm_yyyy(Params::get($key));
                    }
                }

                $peer->{$filter_call}($value);

            }
        }
    }

    public static function updateGroupByFilters($peer)
    {
        if (Params::is_set(self::GROUP_BY_KEY))
        {
            $field = Params::get(self::GROUP_BY_KEY);
            if ($field!="")
                $peer->__GROUP_BY($field);
        }
    }

    /*
     * Aggiorna i risultati del peer includendo la paginazione.
     * es:
     *
     * Aggiungere test per __page_size e __page_num vuoti.
     *
     * __page_size => 15
     * __page_num => 3
     */
    public static function updatePageFilters($peer)
    {
        if (Params::is_set(self::PAGE_SIZE_KEY) && Params::get(self::PAGE_SIZE_KEY)!="" && Params::is_set(self::PAGE_NUM_KEY) && Params::get(self::PAGE_NUM_KEY)!="")
        {
            $page_size = Params::get(self::PAGE_SIZE_KEY);
            $page_num = Params::get(self::PAGE_NUM_KEY);

            $peer->__PAGE($page_num,$page_size);
        }
    }

    public static function getAllPrefixes()
    {
        return array("__page_size","__page_num","__filter_","__order_by","__ordering","__group_by");
    }
}

?>