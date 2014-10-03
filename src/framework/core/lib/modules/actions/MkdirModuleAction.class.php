<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
* Crea una cartella
* */
class MkdirModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->dir = $attributes->relative_path."";
    }
    
    function execute()
    {
        $dir = $this->dir;
    
        if (self::$dummy_mode)
        {
            echo "Mkdir : ".self::$root_dir->getPath().$dir."<br />";
            return;
        }

        $d = new Dir(self::$root_dir->getPath().$dir);
        $d->touch();
    
    }
}

?>