<?php

            /*
     * Droppa una tabella
     * */
class DropTableModuleAction extends AbstractModuleAction
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

        $drop_table = DB::newDropTable($table_name);
        $drop_table->exec();
    
    }
}

?>