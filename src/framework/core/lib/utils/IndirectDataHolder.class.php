<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class IndirectDataHolder extends BasicObject
{
    private $__dataHolder=null;

    public final function __merge($data)
    {
        $this->__dataHolder->__merge($data);
    }

    public final function __set_data_holder($data_holder)
    {
        $this->__dataHolder = $data_holder;
    }

    public final function __get_data_holder()
    {
        return $this->__dataHolder;
    }

    public final function __check_data_holder()
    {
        if ($this->__dataHolder==null) $this->__error(__METHOD__, "Data holder non impostato!");
    }

    /**
     * Magic method
     * Rimuove la definizione di una variabile
     *
     * @param <type> $key
     */
    public function __unset($key)
    {
        $this->__check_data_holder();
        unset($this->__dataHolder->{$key});
    }

    
    /**
     * Magic method
     * controllo presenza chiavi -> redirect al dataholder, che puo' essere anche indiretto
     *
     * @param <type> $key La chiave
     * @return <type> true se è definita quella variabile, false altrimenti
     */
    public function __isset($key)
    {
        $this->__check_data_holder();
        return isset($this->__dataHolder->{$key});
    }

    /**
     * Magic method
     * lettura dei valori -> redirect al dataholder, che puo' essere anche indiretto
     */
    
    public function __get($key)
    {
        $this->__check_data_holder();
        return $this->__dataHolder->{$key};
    }

    /**
     * Magic method
     * scrittura di valori -> redirect al dataholder, che puo' essere anche indiretto.
     */
    
    public function __set($key,$value)
    {
        $this->__check_data_holder();
        $this->__dataHolder->{$key} = $value;
    }

}

?>