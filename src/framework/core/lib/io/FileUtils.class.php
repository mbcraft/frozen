<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class FileUtils
{


    static function randomFromFolder($path,$autocache=true,$include_sub_dirs=false)
    {
        $dir = new Dir($path);
        
        if (!$dir->exists())
            Log::error ("FileUtils::randomFromFolder", "La cartella $path non esiste!!");
        
        if (!$dir->isDir())
            Log::error ("FileUtils::randomFromFolder", "Il percorso $path non rappresenta una cartella!!");
            
        $results = $dir->listFiles();
               
        $valid_results = array();
        
        foreach ($results as $dir_elem)
        {
            if ($dir_elem->isDir() && $include_sub_dirs)
                $valid_results[] = $dir_elem;
            if ($dir_elem->isFile())
                $valid_results[] = $dir_elem;
        }
        
        if (count($valid_results)==0)
            Log::error("FileUtils::randomFromFolder","Non sono stati trovati risultati validi!!");
        
        $selected = $valid_results[rand(0,count($valid_results)-1)];
        
        $final_result = $selected->getPath();
        if ($autocache)
            $final_result.= "?mtime=".$selected->getModificationTime();
        
        return $final_result;
    }

}
?>