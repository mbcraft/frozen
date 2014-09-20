<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * Il layout renderizza qualcosa che viene parsato e salvato.
 * Problemi :
 * La cache diventa un problema quando :
 * 1) Cambia l'implementazione. Soluzione : md5 della classe Layout.
 * 2) Il file viene spostato. In quel caso il problema è che il vecchio file non viene eliminato.
 */

class Layout implements IRenderable,IDumpable
{
    const SECTOR_PATTERN = "/##((\/\w+)+)##/";

    const MARKER_KEY = "___layout";
    
    private $layout_path;
    private $name;
    private $tree_view;
    
    private $layout_cache_key = null;

    public function __setup($layout_path,$name,$tree_view)
    {
        $this->layout_path = $layout_path;
        $this->name = $name;
        $this->tree_view = $tree_view;
    }
    
    private function is_cached()
    {
        return Cache::has_key($this->get_layout_cache_key());
    }
    
    private function get_cached_layout_path()
    {
        return Cache::get_path($this->get_layout_cache_key());
    }
    
    private function get_layout_cache_key()
    {
        if ($this->layout_cache_key!=null) return $this->layout_cache_key;
        
        $layout_class_source = ClassLoader::instance()->get_element_content_by_name(get_class($this));
        $f = new File("/".$this->layout_path);
        $layout_file_path = $f->getPath();
        $layout_file_size = $f->getSize();
        $layout_modification_time = $f->getModificationTime();
        $this->layout_cache_key = md5($layout_class_source.$layout_file_path.$layout_file_size.$layout_modification_time);
    
        return $this->layout_cache_key;
    }

    private function __getLayoutContent() //leggo il contenuto da file
    {
        $f = new File("/".$this->layout_path);
        $file_content = $f->getContent();
        return $file_content;
    }

    public function getSectorNames()
    {
        $matches = array();
        preg_match_all(self::SECTOR_PATTERN,$this->__getLayoutContent(),$matches,PREG_OFFSET_CAPTURE);

        $result = array();
        $real_matches = $matches[1];
        foreach ($real_matches as $match)
        {
            $result[] = $match[0];
        }

        return $result;
    }

    public function getSectorCount()
    {
        $matches = array();
        preg_match_all(self::SECTOR_PATTERN,$this->__getLayoutContent(),$matches);

        return count($matches);
    }
    
    private function process()  //faccio il replace sei settori col
    {  
        $new_content = preg_replace(self::SECTOR_PATTERN,"<? render_path(\"\\1\"); ?>" , $this->__getLayoutContent());
       
        Cache::set($this->get_layout_cache_key(),$new_content);
    }
    /*
     * Effettua il rendering del layout.
     *
     * Viene effettuata prima il preprocessing dei settori, poi l'inclusione del layout per l'interpretazione
     * di eventuali include per css/js e blocchi vari ed infine il rendering.
     */
    public function render()
    {       
        if (!$this->is_cached())
            $this->process();

        $final_include_layout_path = substr($this->get_cached_layout_path(),1);
        ob_start();
        include($final_include_layout_path);
        $rendered_content = ob_get_contents();
        ob_end_clean();

        RenderingStack::push($this->tree_view);
        echo $rendered_content;
        RenderingStack::pop();
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function renderObject($path)
    {
        render($this->tree_view->get($path));
    }
    
    public function __toString() 
    {
        ob_start();
        $this->render();
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
    
    function dump()
    {
        echo "LAYOUT<br />";
        echo "PATH : ".$this->layout_path."<br />";
        echo "CACHE PATH : ".$this->get_cached_layout_path()."<br />";
        echo "NAME : ".$this->name."<br />";
        echo "SECTOR COUNT : ".$this->getSectorCount()."<br />";
        $i = 0;
        foreach ($this->getSectorNames() as $sector_name)
        {
            $i++;
            echo "SECTOR ".$i." : ".$sector_name."<br />";
        }
    }
}

?>