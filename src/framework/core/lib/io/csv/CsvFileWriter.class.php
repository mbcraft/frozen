<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class CsvFileWriter 
{
    private $writer;
    private $my_file;
    private $delimiter;
    
    function __construct($file,$delimiter=",")
    {
        $this->my_file = $file;
        $this->delimiter = $delimiter;
    }
    
    private function openWriter()
    {
        $this->writer = $this->my_file->openWriter();
    }
    
    private function closeWriter()
    {
        $this->writer->close();
        $this->writer = null;
    }
    
    private function write_do($do)
    {
        $array_do = $do->__toArray();
        $this->writer->writeCSV($array_do,$this->delimiter);
    }
    
    function export_from_peer($peer)
    {
        $fields = $peer->__getAllFields();
        $header = join(";",$fields);
        
        $this->openWriter();
        
        $this->writer->writeln($header);
        
        $count = $peer->count();
        $min = 0;
        $num = 100;
        while ($min+$num<$count)
        {
            $peer->__set_limit_filter($min,$num);
            $result = $peer->find();
            foreach ($result as $do) self::write_do($do);
            $min+=$num;
        }
        
        $this->closeWriter();
    }
}

?>