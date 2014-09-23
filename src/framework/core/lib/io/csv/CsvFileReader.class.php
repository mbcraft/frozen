<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class CsvFileReader 
{
    const OPEN_MODE_PEER = "open_mode_peer";
    const OPEN_MODE_ARRAY = "open_mode_array";
    
    private $reader;
    private $my_file;
    private $open_mode;
    private $fields;
    private $peer;
    
    function __construct($file,$delimiter=",")
    {
        $this->my_file = $file;
        $this->delimiter = $delimiter;
    }
    
    private function openReader($fields)
    {
        $this->fields = $fields;
        if ($this->open_mode===self::OPEN_MODE_PEER)
        $this->reader = $this->my_file->openReader();
        
        $header = $this->reader->readLine();
        
        //setup fields
    }
    
    private function closeReader()
    {
        $this->reader->close();
        $this->reader = null;
        $this->open_mode = null;
        $this->fields = null;
        $this->peer = null;
    }
    
    private function read_do($peer)
    {
        $do = $peer->new_do();
        $array_do = $this->reader->readCSV($this->delimiter);
        $do->__fromArray($array_do);
        return $do;
    }
    
    private function read_array()
    {
        return $this->reader->readCSV($this->delimiter);
    }
    
    function open_with_array($keys)
    {
        $this->open_mode = self::OPEN_MODE_ARRAY;
    }
    
    function open_with_peer($peer)
    {        
        $this->openReader(self::OPEN_MODE_PEER,$peer);

        //check sugli header
    }
    
    function readNext($num)
    {
        $result = array();
        for ($i=0;$i<$num;$i++)
        {
            if ($this->mode==self::OPEN_MODE_PEER)
                $result[] = read_do($this->peer);
            else
                $result[] = read_array();
        }
        return $result;
    }
    
    function hasMoreData()
    {
        return !$this->reader->isEndOfStream();
    }
    
    function close()
    {
        $this->closeReader();
    }
}

?>