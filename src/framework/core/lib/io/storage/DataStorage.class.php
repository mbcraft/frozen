<?php

 /* This software is released under the BSD license. Full text at project root -> license.txt */
class DataStorage extends Storage
 {
    function __construct($folder,$name)
    {
        parent::__construct($folder,$name,Storage::DATA_STORAGE);
    }

     function readData()
     {
         $this->create();
         return $this->storage_file->getContent();
     }

     function saveData($data)
     {
         $this->create();
         return $this->storage_file->setContent($data);
     }
 }
 
 ?>