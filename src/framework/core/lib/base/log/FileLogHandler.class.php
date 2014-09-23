<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class FileLogHandler implements ILogHandler
{
    private $log_file;
    
    private $writer;
    
    function __construct($log_file_path)
    {
        $this->log_file = new File($log_file_path);
        $this->log_file->touch();
        
        $this->writer = $this->log_file->openWriter();
    }
    
    function debug($message)
    {
        $this->writer->write($message);
    }
    
    function info($message)
    {
        $this->writer->write($message);
    }
    
    function warn($message)
    {
        $this->writer->write($message);
    }
    
    function error($message)
    {
        $this->writer->write($message);
        $this->writer->close();
        throw new Exception($message);
        
    }
}

?>
