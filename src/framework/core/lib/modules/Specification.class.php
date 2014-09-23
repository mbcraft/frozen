<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * Specifica di modulo o servizi con relativa versione.
 * */
class Specification
{
    private $my_name;
    private $my_version;

    function __construct($name,$version="0")
    {
        if ($name==null) throw new InvalidParameterException("The specification name can't be null!!");
        $this->my_name = $name;

        $this->my_version = $version;
    }

    public function get_version()
    {
        return $this->my_version;
    }

    public function get_name()
    {
        return $this->my_name;
    }

    /*
     * La specifica e' la stessa se e soltanto se il nome coincide
     * */
    public function is_same_spec($another_spec)
    {
        if ($another_spec instanceof Specification && $another_spec->my_name == $this->my_name)
            return true;
        else
            return false;
    }

    /*
     * La specifica A e' compatibile con la specifica B se e solo se
     * 1) hanno lo stesso nome
     * A non ha versione
     * la versione di A e' inferiore a quella di B
     * */
    public function is_compatible_with($another_spec)
    {
        if ($this->is_same_spec($another_spec) && version_compare($this->get_version(),$another_spec->get_version())>=0)
            return true;
        else
            return false;
    }

}

?>