<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
* Aggiunge i file prendendoli dal modulo nella cartella relativa alla root del sito
*/
class AddModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->file_or_folder = $attributes->relative_path."";
    }
    
    function execute()
    {
        $file_or_folder = $this->file_or_folder;
    
        if (self::$dummy_mode)
        {
            echo "Adding : ".$file_or_folder."<br />";
            return;
        }

        $root_dir_path = self::$root_dir->getPath();

        $file_or_folder = str_replace("\\", "/", $file_or_folder);

        $file_list = array();

        //se finisce con lo slash è una directory
        if (substr($file_or_folder, strlen($file_or_folder)-1,1)=="/") //directory
        {
            //creo la cartella
            $target_dir = new Dir(DS.$root_dir_path.$file_or_folder);
            $target_dir->touch();
            
            $source_dir = new Dir($this->module_dir->getPath().$file_or_folder);
            foreach ($source_dir->listFiles() as $elem)
            {
                if ($elem->isDir())
                    $file_list = array_merge($file_list,$this->add($file_or_folder.$elem->getName().DS));
                else
                    $file_list = array_merge($file_list,$this->add($file_or_folder.$elem->getFilename()));
            }
        }//altrimenti è un file
        else
        {
            $source_file = new File($this->module_dir->getPath().$file_or_folder);
            $target_file = new File($root_dir_path.$file_or_folder);
            
            $target_dir = $target_file->getDirectory();
            $target_dir->touch();
            
            $source_file->copy($target_dir);
            $file_list [] = $target_dir->newFile($source_file->getFilename())->getPath();
        }

        return $file_list;
    
    }
}

?>
