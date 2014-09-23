<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/**
 * Description of DataHolder
 *
 * Questa classe è stata potenziata notevolmente dall'implementazione originale.
 * Accesso in scrittura tramite set. (rimosso quello tramite metodo)
 * Supporto opzionale delle costanti : una volta scritte non sono più modificabili.
 * Ciò che non viene trovato chiama il metodo della superclasse.
 * Aggiunto il supporto al lock : una volta lockato un DataHolder non può più essere modificato.
 * Usato per le view. Aggiunto supporto ad unset per eliminare variabili (non costanti).
 * Aggiunto warning per impostazione a null di variabili.
 *
 * Nota : Una variabile che non esiste non da nemmeno warning (chissà forse dipende dal warning level)...
 *
 * @author frostlabgate
 */
class DataHolder
{
    private $__frozen;

    private $__constants = array();
    private $__variables = array();

    private $__where = array();

    private $__locked = false;

    private $__warn_for_null_values;
    private $__enable_constants;

    private $__parentHolder = null;
    
    
    public function __construct($uppercase_are_constants = true,$warn_for_null_values = true)
    {
        $this->__frozen = false;
        $this->__enable_constants = $uppercase_are_constants;
        $this->__warn_for_null_values = $warn_for_null_values;
    }

    public final function __set_parent_holder($data_holder)
    {
        $this->__parentHolder = $data_holder;
    }

    public function __freeze()
    {
        $this->__frozen = true;
    }

    public function __unfreeze()
    {
        $this->__frozen = false;
    }

    public function __merge($object)
    {
        if ($object instanceof DataHolder)
            $vars = $object->__get_variables();
        else
            if ($object instanceof AbstractDO)
                $vars = $object->__get_fields();
            else
                if (is_array($object))
                    $vars = $object;
                else
                    $vars = get_object_vars($object);
        
        foreach ($vars as $key => $value)
        {
            if (strpos($key,"__")!==0) //skip variabili che cominciano con "__" in quanto "nascoste".
                $this->{$key} = $value;
        }
    }

    public function clean()
    {
        $this->__constants = array();
        $this->__variables = array();
        $this->__where = array();
    }

    public final function __where($key)
    {
        return $this->__where[$key];
    }

    public final function __lock()
    {
        $this->__locked = true;
    }

    public final function __locked()
    {
        return $this->__locked;
    }

    private function __check_null_values($key,$value)
    {
        if ($value===null && $this->__warn_for_null_values)
            Log::warn(__METHOD__,"Attenzione, variabile o costante impostata a null : KEY=$key .");
    }

    private function __setConstant($key,$value)
    {
        $this->__check_null_values($key, $value);
        if (array_key_exists($key, $this->__constants))
        {
            Log::error(__METHOD__,"Tentativo di modificare una costante gia' impostata nel file ".$this->__where[$key]." : KEY=$key VALUE=$value . File corrente : ".__FILE__);
        }
        else
        {
            $this->__constants[$key] = $value;
            $this->__where[$key] = __FILE__;
        }
    }

    private function &__getConstant($key)
    {
        if (array_key_exists($key, $this->__constants))
        {
            if (is_array($this->__constants[$key]))
                return $this->__constants[$key];
            else
                return $this->__constants[$key];
        }
        if ($this->__parentHolder!=null)
            return $this->__parentHolder->{$key};
        else
            Log::error(__METHOD__, "Costante nel DataHolder non trovata : $key");
        
    }

    private function __setVariable($key,$value)
    {
       $this->__check_null_values($key, $value);
       $this->__variables[$key] = $value;
       $this->__where[$key] = __FILE__;
    }

    private function &__getVariable($key)
    {
        if (array_key_exists($key, $this->__variables))
        {
            if (is_array($this->__variables[$key]))
                return (array)$this->__variables[$key];
            else
                return $this->__variables[$key];

        }
        if ($this->__parentHolder!=null)
            return $this->__parentHolder->{$key};
        else
            Log::error(__METHOD__, "Variabile nel DataHolder non trovata : $key");
        
    }

    private function __is_constant($key)
    {
        if (strtoupper($key)==$key && $this->__enable_constants) return true;
        else return false;
    }

    /*
     * Utilizzata per sapere se una COSTANTE o una variabile sono impostate.
     */
    public function __isset($key)
    {
        if ($this->__is_constant($key))
            $result = array_key_exists($key, $this->__constants);
        else
            $result = array_key_exists($key, $this->__variables);
        if (!$result && $this->__parentHolder!=null)
            return isset($this->__parentHolder->{$key});
        else
            return $result;
    }

    public function __unset($key)
    {
        if ($this->__locked) Log::error(__METHOD__, "Tentativo di unset di variabile o costante in DataHolder bloccato.");
        if ($this->__is_constant($key)) Log::error(__METHOD__, "Tentativo di eliminare una costante!");
        Log::info(__METHOD__,"Variabile eliminata : KEY=$key .");
        unset($this->__variables[$key]);
    }

    public function &__get($key)
    {
        //GET
        if ($this->__is_constant($key)) return $this->__getConstant($key);
        else return $this->__getVariable($key);
    }

    public function __set($key,$value)
    {
        if ($this->__frozen && $this->__isset($key)) return;
        if ($this->__locked) Log::error(__METHOD__, "Tentativo di scrittura di variabile o costante in DataHolder bloccato.");
        if ($this->__is_constant($key)) $this->__setConstant($key,$value);
        else $this->__setVariable($key,$value);
    }

    public final function __get_constants()
    {
        if (!$this->__enable_constants) Log::error(__METHOD__, "Impossibile ottenere le costanti : non supportate.");
        else
            return $this->__constants;
    }

    public final function __get_variables()
    {
        return $this->__variables;
    }

    public final function __set_constants($constants)
    {
        return $this->__constants = $constants;
    }

    public final function __set_variables($variables)
    {
        $this->__variables = $variables;
    }

    public final function dump()
    {
        var_dump($this->__variables);
        var_dump($this->__constants);
    }

}
?>