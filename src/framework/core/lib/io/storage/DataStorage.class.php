<?php

 /* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
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