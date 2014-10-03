<?php

/*
* Rimuove dei campi da una tabella
* */
class DropTableFieldsModuleAction extends AbstractModuleAction
{
   
    function setup($tag,$attributes)
    {
        $this->tag = tag;
        $this->attributes = $attributes;
    }
    
    function execute()
    {

        $definition = $this->tag;
    
        $table_name = $definition->attributes()->table_name;

        $drop_fields = DB::newAlterTable($table_name);
        foreach ($definition as $tag_name => $tag)
        {
            $drop_fields->drop_column($tag->attributes()->name);
        }
    
    }
}

?>