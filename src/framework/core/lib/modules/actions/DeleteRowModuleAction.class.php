<?php

/*
* Elimina una riga da una tabella
* */
class DeleteRowModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->tag = tag;
        $this->attributes = $attributes;
    }
    
    function execute()
    {
        $definition = $this->tag;
    
        $table_name = $definition->attributes()->from;

        $table_desc = DB::newTableFieldsDescription($table_name);

        $pk_fields = $table_desc->getPrimaryKeyFields();

        $delete = DB::newDelete($table_name);
        $delete->addConditionEquals($pk_fields[0],$definition->attributes()->id);
        $delete->exec();
    
    }
}

?>