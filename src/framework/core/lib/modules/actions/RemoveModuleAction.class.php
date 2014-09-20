<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
* Rimuove tutti i file presenti all'interno di un modulo dalla root del sito
* */
class RemoveModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->file_or_folder = $attributes->relative_path."";
        
        $this->force = isset($attributes->force) && "".$attributes->force=="true" ? true : false;
    }
    
    function execute()
    {

        $file_or_folder = $this->file_or_folder;
        $force = $this->force;
    
        if (self::$dummy_mode)
        {
            echo "Removing : ".$file_or_folder."<br />";
            return;
        }

        $root_dir_path = self::$root_dir->getPath();
        
        //se è una cartella elimino solo i file che sono anche nel modulo
        if (FileSystemUtils::isDir($this->module_dir->getPath().$file_or_folder))
        {        
            $source_dir = new Dir($this->module_dir->getPath().$file_or_folder);
            $target_dir = new Dir($root_dir_path.$file_or_folder);
            if (!$target_dir->exists()) return;
            
            $toremove_files = $source_dir->listFiles();
            foreach ($toremove_files as $elem)
            {
                if ($elem->isDir())
                    $this->remove($file_or_folder.$elem->getName().DS);
                else
                    $this->remove($file_or_folder.$elem->getFilename());
                    
            }
            
            if ($target_dir->isEmpty())
                $target_dir->delete(false);
        }
        else    //se è un file lo elimino
        {           
            $source_file = new File($this->module_dir->getPath().$file_or_folder);
            
            $target_file = new File($root_dir_path.$file_or_folder);
            if (!$force && !$source_file->exists()) return;    //se non esiste nel modulo non lo rimuovo
            $target_file->delete();
        }
    
    }
}

?>