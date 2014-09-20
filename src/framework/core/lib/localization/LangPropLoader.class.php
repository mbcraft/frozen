<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class LangPropLoader
{
    public static function loadByLang($result,$lang,$dir,$recursive = false)
    {        
        if ($dir instanceof Dir)
            $props_dir = new Dir($dir);
        else
            $props_dir = new Dir($dir);
        
        $all_files = $props_dir->listFiles();
        foreach ($all_files as $f)
        {
            if ($f->isDir() && $recursive)
                $result = array_merge ($result,self::loadByLang ($result,$lang, $f,true));
            if ($f->isFile())
            {
                $full_extension = $f->getFullExtension();

                $ext_parts = explode(".",$full_extension);
                if (count($ext_parts)==2 && $ext_parts[1]=="ini")
                {
                    $lang_part = $ext_parts[0];
                    if (substr($lang_part,0,strlen($lang))==$lang)
                    {
                        $result = array_merge($result,PropertiesUtils::readFromFile($f, false));
                    }
                }
                    
            }
        }
    }
}

?>