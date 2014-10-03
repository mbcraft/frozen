<?php

/*
* Rinomina una tabella
* */
class RenameTableModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->tag = tag;
        $this->attributes = $attributes;
    }
    
    function execute()
    {

        $definition = $this->tag;
    
        $source = $definition->attributes()->from;
        $new_name = $definition->attributes()->to;

        $rename_table = DB::newAlterTable($source);
        $rename_table->rename($new_name);
    
    }
}

?>