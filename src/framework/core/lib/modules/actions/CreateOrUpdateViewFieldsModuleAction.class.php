<?php

/*
* Crea o modifica una vista
* */
class CreateOrUpdateViewFieldsModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->tag = tag;
        $this->attributes = $attributes;
    }
    
    private function __load_import_fields($edit_view,$tag)
    {
        $table_name = "".$tag->attributes()->table_name;

        foreach ($tag as $tag_name => $tag_data)
        {
            if ($tag_name=="field")
            {
                $attr = $tag_data->attributes();

                $from = isset($attr->from) ? "".$attr->from : "".$attr->name;

                $edit_view->addViewField($table_name,$from,"".$attr->name);
            }
            else throw new InvalidDataException("Il tag ".$tag_name." non e' supportato all'interno del tag import_fields.");
        }
    }

    private function __load_join($edit_view,$tag)
    {
        $attr = $tag->attributes();

        $to_field = isset($attr->to_field) ? "".$attr->to_field : "".$attr->from_field;

        $edit_view->addJoinFields("".$attr->from_table,"".$attr->from_field,"".$attr->to_table,$to_field);
    }
    
    function execute()
    {

        $definition = $this->definition;
    
        $view_name = $definition->attributes()->view_name;
        $db_desc = DB::newDatabaseDescription();

        if (!$db_desc->hasTable($view_name))
        {
            $edit_view = DB::newCreateView($view_name);
        }
        else
        {
            $edit_view = DB::newAlterView($view_name);
        }

        foreach ($definition as $tag_name => $tag)
        {
            switch ($tag_name)
            {
                case "join": $this->__load_join($edit_view,$tag);break;
                case "import_fields": $this->__load_import_fields($edit_view,$tag);break;

                default: throw new InvalidParameterException("Il tag : ".$tag_name." non e' supportato.");
            }
        }

        $edit_view->exec();
    
    }
}

?>