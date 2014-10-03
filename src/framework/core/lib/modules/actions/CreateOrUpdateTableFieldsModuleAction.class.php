<?php

/*
* Aggiorna i campi di una tabella presente nel database o ne crea una nuova
* */
class CreateOrUpdateTableFieldsModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->tag = tag;
        $this->attributes = $attributes;
    }
    
    function execute()
    {

        $definition = $this->tag;
    

        $field_factory = __MysqlTableFieldFactory::instance();
        $field_list = array();
        $rename_list = array();

        foreach ($definition as $tag_name => $tag)
        {
            $attr = $tag->attributes();

            switch ($tag_name)
            {
                case "primary_key":
                case "unique":
                case "fulltext":
                case "index": $field = $field_factory->{"create_".$tag_name}($attr->name); break;
                case "autoincrement_id": $field = $field_factory->{"create_".$tag_name}($attr->name,(isset($attr->null) && $attr->null=="true") ? true : false,isset($attr->comment) ? $attr->comment : null,isset($attr->after_col_or_first) ? $attr->after_col_or_first : null,isset($attr->rename_from)); break;
                case "external_id":
                case "text_16":
                case "text_32":
                case "text_64":
                case "text_128":
                case "text_512":
                case "text_1024":
                case "text_65k":
                case "text_big":
                case "bool":
                case "unsigned_int_8":
                case "unsigned_int_32":
                case "signed_int_8":
                case "signed_int_32":
                case "double":
                case "numeric":
                case "date":
                case "time":
                case "datetime":
                case "timestamp":$field = $field_factory->{"create_".$tag_name}($attr->name,(isset($attr->null) && $attr->null=="true") ? true : false,isset($attr->comment) ? $attr->comment : null,isset($attr->after_col_or_first) ? $attr->after_col_or_first : null); break;
                default: throw new InvalidParameterException("Il tag : ".$tag_name." non e' supportato.");
            }

            if (isset($attr->rename_from))
            {
                $rename_list["".$attr->rename_from] = $field;
            }
            else
            {
                $field_list[] = $field;
            }
        }

        //Flash::warning(count($rename_list));

        $table_name = $definition->attributes()->table_name;
        $db_desc = DB::newDatabaseDescription();

        //if (count($rename_list)>0 && $db_desc->hasTable($table_name))
        //    throw new IllegalStateException("Non è possibile creare la tabella se ci sono dei rename da effettuare!!");

        //aggiungere controllo su campi già presenti nella tabella e spostarli come change



        if (!$db_desc->hasTable($table_name))
        {
            $create_table = DB::newCreateTable($table_name);
            foreach ($field_list as $i => $definition)
            {
                $create_table->add_column($definition);
            }
            $create_table->exec();
        }
        else
        {

            if (count($field_list)>0 || count($rename_list)>0)
            {
                $alter = DB::newAlterTable($table_name);

                foreach ($field_list as $ix => $definition)
                {
                    $alter->add_column($definition);
                }


                foreach ($rename_list as $old_name => $definition)
                {
                    $alter->change_column($old_name,$definition);
                }
            }
            else
                Flash::warning("No fields found in field list!!");

        }

    
    }
}

?>