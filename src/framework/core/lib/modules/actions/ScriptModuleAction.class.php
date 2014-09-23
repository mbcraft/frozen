<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
* Esegue un file php se trovato
* */
class ScriptModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->nome_script = $attributes->relative_path;
        $this->parameters = array();
    }
    
    function execute()
    {

        $nome_script = $this->nome_script;
        $parameters = $this->parameters;
    
        if (self::$dummy_mode)
        {
            echo "Run script if found : ".$this->module_dir->getPath()."/script/".$nome_script.".php<br />";
            return;
        }


        extract($parameters);
        $f = new File($this->module_dir->getPath()."/script/".$nome_script.".php");
        if ($f->exists())
        {
            include ($f->getIncludePath());

            return true;
        }
        else return false;
    
    }
}

?>