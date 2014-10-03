<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */
class PropertiesStorage extends Storage
{
    function __construct($folder,$name)
    {
        parent::__construct($folder,$name,Storage::PROPERTIES_STORAGE);
    }

    /*Properties*/
    function readAll()
    {
        $this->create();
        return PropertiesUtils::readFromFile($this->storage_file, true);
    }

    function saveAll($props)
    {
        $this->create();
        PropertiesUtils::saveToFile($this->storage_file, $props, true);
    }

    function add($key,$values_array)
    {
        $this->create();
        PropertiesUtils::addEntry($this->storage_file, true, $key, $values_array);
    }

    function remove($key)
    {
        $this->create();
        PropertiesUtils::removeEntry($this->storage_file, true, $key);
    }
    /*Non properties*/
}
 
?>