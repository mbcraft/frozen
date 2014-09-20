<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class FileReader
{
    protected $my_handle;
    protected $open;
    
    function __construct($handle)
    {
        $this->my_handle = $handle;
        $this->open = true;
    }

    protected function checkClosed()
    {
        if (!$this->open) throw new IllegalStateException("Lo stream risulta essere chiuso!!");
    }

    function isOpen()
    {
        return $this->open;
    }

    function scanf($format)
    {
        $this->checkClosed();

        return fscanf($this->my_handle,$format);
    }
    
    function read($length)
    {
        $this->checkClosed();

        return fread($this->my_handle,$length);
    }
    
    function readLine()
    {
        $this->checkClosed();

        $line = fgets($this->my_handle);
        return preg_replace("/\r?\n\Z/","",$line);
    }
    
    function readChar()
    {
        $this->checkClosed();

        return fgetc($this->my_handle);
    }
    
    function readCSV($delimiter=",")
    {
        $this->checkClosed();

        return fgetcsv($this->my_handle,$delimiter);
    }

    function reset()
    {
        $this->checkClosed();

        rewind($this->my_handle);
    }
    
    function seek($location)
    {
        $this->checkClosed();

        fseek($this->my_handle,$location,SEEK_SET);
    }
    
    function skip($offset)
    {
        $this->checkClosed();

        fseek($this->my_handle,$offset,SEEK_CUR);
    }
    
    function pos()
    {
        $this->checkClosed();

        return ftell($this->my_handle);
    }
        
    function isEndOfStream()
    {
        $this->checkClosed();

        return feof($this->my_handle);
    }
    
    function close()
    {
        if ($this->open)
        {
            fflush($this->my_handle);
            flock($this->my_handle,LOCK_UN);
            fclose($this->my_handle);

            $this->open = false;
            $this->my_handle = null;
        }
        else
            throw new IllegalStateException("Reader/Writer already closed.");

    }
    
    function getHandler()
    {
        return $this->my_handle;
    }
}

?>