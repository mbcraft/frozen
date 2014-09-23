<?

/* This software is released under the BSD license. Full text at project root -> license.txt */

class TextEditor
{
    private $content="";
    private $changes = array();
        
    function load_content_from_file($f)
    {
        $this->content = $f->getContent();
    }
    
    function save_content_to_file($f)
    {
        $f->setContent($f);
    }
    
    function get_content()
    {
        return $this->content;
    }
    
    function set_content($content)
    {
        return $this->content = $content;
    }
    
    function matches_pattern($pattern,$all=false)
    {     
        $matches = array();
        
        if ($all)
            preg_match_all($pattern,$this->content,$matches,PREG_OFFSET_CAPTURE);
        else
            preg_match($pattern, $this->content,$matches,PREG_OFFSET_CAPTURE);
        
        return $matches;
    }
    
    function get_changes_count()
    {
        return count($this->changes);
    }
    
    function insert($position,$text)
    {
        $this->push_change($position, 0, $text);
    }
    
    function delete($position,$length)
    {
        $this->push_change($position,$length,"");
    }
    
    function replace($start,$end,$text)
    {
        $this->push_change($start,$end-$start,$text);
    }
    
    function push_change($start,$length,$text)
    {
        array_push($this->changes, array("start" => $start,"text" => $text,"length" => $length));
    }
    
    function pop_change()
    {
        array_pop($this->changes);
    }
    
    function reset_changes()
    {
        $this->changes = array();
    }
    
    function preview_changes($num=-1)
    {
        if ($num==-1) $num = $this->get_changes_count();
        
        $content = $this->content;
        
        for($i=0;$i<$num;$i++)
        {
            $current_change = $this->changes[$i];
            
            $before_text = substr($content, 0,$current_change["start"]);
            $text = $current_change["text"];
            $after_text = substr($content,$current_change["start"]+$current_change["length"]);
            
            $content = $before_text.$text.$after_text;
        }
        
        return $content;
    }
    
    function apply_changes($num=-1)
    {
        $this->set_content($this->preview_changes($num));
        $this->reset_changes();
    }
}

?>