<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */


class Block extends BasicObject implements IRenderable,IDumpable
{
    const MARKER_KEY = "___block";
    
    private $path;
    private $name;
    private $params;

    function __construct($block_path,$name,$params)
    {
        $this->block_path = $block_path;
        $this->name = $name;
        $this->params = $params;
    }
    
    /*
     *
     * Effettua il rendering del blocco.
     */
    public function render()
    {
        extract($this->params);
        include ($this->block_path);
    }
    
    public function getParams()
    {
        return $this->params;
    }

    public function getPath()
    {
        return $this->path;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function __toString() 
    {
        ob_start();
        $this->render();
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
    
    function dump()
    {
        echo "--- BLOCK<br />";
        echo "PATH : ".$this->path."<br />";
        echo "NAME : ".$this->name."<br />";
        echo "PARAMS : ".$this->params."<br />";
        echo "---<br />";
    }
}
?>