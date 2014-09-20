<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class FormData
{    
    const FORM_DATA_KEY_NAME = "key";
    const FORM_DATA_VALUE_NAME = "value";
    
    private $form_data;
    
    function reset_data()
    {
        $this->form_data = array();
    }
    
    function merge_key_value($data)
    {
        $key = $data[self::FORM_DATA_KEY_NAME];
        $value = $data[self::FORM_DATA_VALUE_NAME];
        
        $this->form_data[$key] = $value;
    }
    
    function merge_direct($data)
    {
        foreach ($data as $k => $v)
            $this->form_data[$k] = $v;
    }
    
    function get_data()
    {
        return $this->form_data;
    }
    
    function get_value_or_null($key)
    {
        if (isset($this->form_data[$key]))
                return $this->form_data[$key];
    }
}

?>