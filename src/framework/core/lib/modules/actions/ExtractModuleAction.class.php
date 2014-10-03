<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
* Estrare un archivio fga nella rispettiva cartella
* */
class ExtractModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->archive_file_path = $attributes->relative_archive_path;
        $this->to_folder = $attributes->extract_to;
    }
    
    function execute()
    {

        $archive_file_path = $this->archive_file_path;

        $to_folder = $this->to_folder;
    

        if (self::$dummy_mode)
        {
            echo "Extracting : ".$archive_file_path." to ".$to_folder."<br />";
            return;
        }

        $real_archive_file_path = new File($this->module_dir.DS.$archive_file_path);
        
        $real_folder = new Dir(self::$root_dir.DS.$to_folder);
        
        FGArchive::extract($real_archive_file_path, $real_folder);
    
    }
}


?>