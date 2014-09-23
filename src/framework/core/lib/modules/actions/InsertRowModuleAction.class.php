<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
* Inserisce una riga in una tabella
* */
class InsertRowModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->tag = tag;
        $this->attributes = $attributes;
    }
    
    function execute()
    {

        $definition = $this->tag;
    
        $table_name = $definition->attributes()->to;

        $create = DB::newInsert($table_name);
        foreach ($definition as $tag_name => $tag)
        {
            $create->add($tag->attributes()->name,"".$tag);
        }
        $create->exec();
    
    }
}

?>