<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/**
 * Classe astratta comune per tutti i data object.
 * Mantiene traccia dei campi modificati.
 */
abstract class AbstractDO extends BasicObject implements InitializeAfterLoad
{
    const CLASS_FIELD_KEY = "___class";
    
    protected $__loading = false;
    protected $__new = true; //insert
    protected $__changed = false; //questo flag viene utilizzato per segnalare che ci sono dei campi da salvare per un update
    protected $__deleted = false;
    protected $__changedFields = array();
    protected $__fieldsSet = array();

    public function __get_fields()
    {
        return $this->__fieldsSet;
    }

    public function __dumpInternalState()
    {
        echo "Loading : ".$this->__loading." <br/>";
        echo "New : ".$this->__new." <br/>";
        echo "Changed : ".$this->__changed." <br/>";
        echo "Deleted : ".$this->__deleted." <br/>";
    }

    public function __setLoadingState($state)
    {
        $this->__loading = $state;
    }

    public function __markAsNotNew()
    {
        $this->__new = false;
    }

    public function __markAsChanged()
    {
        $this->__changed = true;
    }

    public function __markAsSaved()
    {
        $this->__new = false;
        $this->__changed = false;
        $this->__changedFields = array();
    }

    public function __markAsDeleted()
    {
        $this->__new = false;
        $this->__changed = false;
        $this->__deleted = true;
    }

    public function __isNew()
    {
        return $this->__new;
    }

    public function __isChanged()
    {
        return $this->__changed;
    }

    public function __isDeleted()
    {
        return $this->__deleted;
    }

    public function __fieldChanged($field)
    {
        if (!array_key_exists($field, $this->__changedFields))
            $this->__changedFields[] = $field;
    }

    public function __getChangedFields()
    {
        return $this->__changedFields;
    }
    
    public function __set($key,$value)
    {
        //ritorno il valore
        //ho capito, una volta che effettuo una set il campo esiste e non entra più qua ... :/
        //echo "KEY : ".$key;
        //echo "ALL CACHED FIELDS";
        //var_dump(ActiveRecord::$cachedAllFields[$this->__getRawClassName()]);

        if (array_key_exists($key, ActiveRecord::$cachedAllFields[$this->__getRawClassName()]))
        {
            if (!$this->__loading && !$this->__new && array_key_exists($key, $this->__fieldsSet)) $old_value = $this->__fieldsSet[$key];

            $this->__fieldsSet[$key] = $value;
            
            if (!$this->__loading && !$this->__new && $this->__fieldsSet[$key]!=$old_value)
            {
                $this->__markAsChanged();
                $this->__fieldChanged($key);
            }
        }
        else
            $this->__error(__METHOD__,"Impossibile modificare il campo $key col valore $value : campo non dichiarato nella tabella : ".join(",",ActiveRecord::$cachedAllFields[$this->__getRawClassName()]));
    }

    public function __isset($key)
    {
        return array_key_exists($key, $this->__fieldsSet);
    }

    public function &__get($key)
    { 
        //ritorno il valore
        if (array_key_exists($key, ActiveRecord::$cachedAllFields[$this->__getRawClassName()]))
        {
            if (is_array($this->__fieldsSet[$key]))
            {
                $this->__fieldChanged($key);
                $this->__markAsChanged();
            }
            return $this->__fieldsSet[$key];
        }
        else
            $this->__error(__METHOD__,"Impossibile ritornare il campo $key : campo non dichiarato.");

    }

    public function __http_get_id()
    {
        $pks = ActiveRecord::$cachedPrimaryKeyFields[$this->__getRawClassName()];
        $result="?";
        foreach ($pks as $key)
        {
            $result.=$key."=".$this->{$key}."&";
        }
        return substr($result, 0,strlen($result)-1);
    }

    public function __http_post_id()
    {
        $pks = ActiveRecord::$cachedPrimaryKeyFields[$this->__getRawClassName()];
        $result = "";
        foreach ($pks as $key)
        {
            $result.="<input type='hidden' name='$key' value='$this->{$key}'>\n";
        }
        return $result;
    }

    public final function __load_from_post()
    {
        $field_list = ActiveRecord::$cachedAllFields[$this->__getRawClassName()];
        foreach ($field_list as $key => $value)
        {
            if (isset($_POST[$key]))
                $this->{$key} = $_POST[$key];
        }
    }

    public final function __load_from_get()
    {
        $field_list = ActiveRecord::$cachedAllFields[$this->__getRawClassName()];
        foreach ($field_list as $key => $value)
        {
            if (isset($_GET[$key]))
                $this->{$key} = $_GET[$key];
        }
    }
    
    /*
     * Carica i dati da un array chiave => valore
     */
    public final function __fromArray($data)
    {
        foreach ($data as $k => $v)
        {
            if ($k!=self::CLASS_FIELD_KEY)
            {
                //codice pronto da usare per la trasformazione degli oggetti in cascata.
                /* 
                //associazione tramite chiave esterna
                if (ActiveRecord::isValidArrayDO($v))
                {
                    $this->{$k} = ActiveRecord::fromArray($v);
                }
                else
                if (is_array($v)) //associazione tramite tabella esterna
                {
                    $result = array();
                    foreach ($v as $nes_key => $nes_value)
                    {
                        $result[] = ActiveRecord::fromArray($nes_value);
                    }
                    $this->{$k} = $result;
                }
                else*/
                    $this->{$k} = $v;
            }
        }
    }
    
    /*
     * Salva i dati in un'array chiave => valore
     */
    public final function __toArray()
    {
        $data = array();
        
        $all_fields = $this->__get_fields();
        
        foreach ($all_fields as $key => $value)
        {
            $data[$key] = $value;
        }
        
        $data[self::CLASS_FIELD_KEY] = $this->__getRawClassName();
        
        return $data;
    }
    
    private function __getRawClassName()
    {
        $class_name = get_class($this);
        return substr($class_name,0,strlen($class_name)-2);
    }
    
    private static function __getStaticRawClassName($class_name)
    {
        return substr($class_name,0,strlen($class_name)-2);
    }

    public static function __classLoaded($class_name)
    {
        ActiveRecord::init(self::__getStaticRawClassName($class_name));
    }

    public function __ID()
    {
        $raw_class_name = $this->__getRawClassName();
        $pks = ActiveRecord::getPrimaryKeyFields($raw_class_name);
        return $this->{$pks[0]};
    }
    

}

?>