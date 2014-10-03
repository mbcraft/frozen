<?php

/*
* Esegue un file sql se trovato
* */
class SqlModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->nome_script = $attributes->relative_path;
    }
    
    function execute()
    {
        $nome_script = $this->nome_script;
    
        if (self::$dummy_mode)
        {
            echo "Execute sql if found : ".$this->module_dir->getPath()."/sql/".$nome_script.".sql<br />";
            return;
        }

        $script_file = new File($this->module_dir->getPath()."/sql/".$nome_script.".sql");

        if ($script_file->exists())
        {
            $script_sql = $script_file->getContent();

            $direct_sql_query = DB::newDirectSql($script_sql);
            $direct_sql_query->exec();

            return true;
        }
        else
            return false;
    
    }
}

?>