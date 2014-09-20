<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class MenuItem
{
    const MENU_LAYOUT_FOLDER = "/include/menu/";
    
    private $menu_layout_dir; 
    
    private $data;
    private $level;
    
    private $current_index;
    
    function __construct($menu_layout_dir,$data,$level)    
    {
        $this->menu_layout_dir = $menu_layout_dir;
 
        $this->data = $data;
        $this->level = $level;
        
        $this->current_index=0;
    }
    
    private function has_childs()
    {
        return isset($this->data["childs"]) && count($this->data["childs"])>0;
    }
    
    private function has_more_childs()
    {
        if ($this->has_childs())
        {
            return $this->current_index<$this->get_max_childs();
        }
        else 
        {
            return false;
        }
    }
    
    /*
     * Ritorna il numero massimo di figli per questo elemento.
     */
    private function get_max_childs()
    {
        return count($this->data["childs"]);
    }
    
    /*
     * Renderizza l'elemento corrente
     */
    function render()
    {
        $current_level_file_path = $this->menu_layout_dir->getPath()."level_".$this->level.".php.inc";
        $level_include_path = substr($current_level_file_path,1);
        
        $title = isset($this->data["title"]) ? Html::escape_special_characters($this->data["title"]) : null;
        $link = isset($this->data["link"]) ? $this->data["link"] : null;
        if (isset($this->data["link_class"]))
            $link_class = $this->data["link_class"];
        if (isset($this->data["target"]))
            $target = $this->data["target"];
                
        include($level_include_path);
    }
    
    function write_child()
    {
        $all_childs = $this->data["childs"];
        $child = new MenuItem($this->menu_layout_dir,$all_childs[$this->current_index],$this->level+1);
        $this->current_index+=1;
        $child->render();

    }
    
    function write_all_childs()
    {
        while ($this->has_more_childs())
        {
            $this->write_child();
        }
    }
    
}
?>