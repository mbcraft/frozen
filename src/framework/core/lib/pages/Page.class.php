<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class Page implements IRenderable,IDumpable
{
    private $__page_path;
    private $__name;

    public function __setup($page_path,$name)
    {
        $this->__page_path = $page_path;
        $this->__name = $name;
    }

    public function render()
    {
        RenderingStack::push(PageData::instance());
        include($this->__page_path);
        RenderingStack::pop();
    }

    public function getName()
    {
        return $this->__name;
    }
    
    public function __toString() 
    {
        ob_start();
        $this->render();
        $string = ob_get_contents();
        ob_end_clean();
        return $string;
    }
    
    
    
    function dump()
    {
        echo "PAGE<br />";
        echo "PATH : ".$this->__page_path."<br />";
        echo "NAME : ".$this->__name."<br />";
    }
}

?>