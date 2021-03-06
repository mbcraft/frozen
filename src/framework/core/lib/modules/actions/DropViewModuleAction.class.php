<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
* Cancella una vista
* */
class DropViewModuleAction extends AbstractModuleAction
{
    function setup($tag,$attributes)
    {
        $this->tag = tag;
        $this->attributes = $attributes;
    }
    
    function execute()
    {

        $definition = $this->tag;
    
        $view_name = $definition->attributes()->view_name;

        $drop_view = DB::newDropView($view_name);
        $drop_view->exec();
    
    }
}

?>