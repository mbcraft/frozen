<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 * Questa classe rappresenta la descrizione di un'operazione.
 * Serve per generare in automatico la descrizione e le api.
 */
class OperationDescription 
{
    const READ_OPERATION = "read";
    const WRITE_OPERATION = "write";
    
    private $my_data = null;
    
    static function read()
    {
        return new OperationDescription(self::READ_OPERATION);
    }
    
    static function write()
    {
        return new OperationDescription(self::WRITE_OPERATION);
    }
    
    private function __construct($type)
    {
        $this->my_data = new PageData();
        
        $this->my_data->set("/type",$type);
 
        $this->my_data->set("/params",array());
        
        $this->my_data->set("/return_value/type","void");
        $this->my_data->set("/return_value/description","This function has no return value.");
        
    }
    
    function description($description)
    {
        $this->my_data->set("/description",$description);
    }
    
    function param($name,$type,$description)
    {
        $this->my_data->set("/params/$name/type",$type);
        $this->my_data->set("/params/$name/description",$description);  
    }
    
    
    function returns($type,$description)
    {
        $this->my_data->set("/return_value/type",$type);
        $this->my_data->set("/return_value/description",$description);
    }
    
    function after()
    {
        
    }
    
    function before()
    {
        
    }
    
    function instead()
    {
        
    }

    function getAll()
    {
        return $this->my_data->get("/");
    }
    
}

?>