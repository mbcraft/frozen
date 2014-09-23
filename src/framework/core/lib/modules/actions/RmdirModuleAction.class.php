<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
* Elimina una cartella
* */
class RmdirModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->dir = $attributes->relative_path."";
        $this->force = isset($attributes->force) && "".$attributes->force=="true" ? true : false;
    }
    
    function execute()
    {

        $dir = $this->dir;
        $force = $this->force;
    
        if (self::$dummy_mode)
        {
            echo "Rmdir : ".self::$root_dir->getPath().$dir."<br />";
            return;
        }

        $d = new Dir(self::$root_dir->getPath().$dir);
        if ((!$d->isEmpty() && $force) || $d->isEmpty())
            $d->delete(true);
    
    }
}

?>