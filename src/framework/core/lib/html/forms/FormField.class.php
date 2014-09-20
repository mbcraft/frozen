<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class FormField implements IFormFieldTypes
{
    private $key;
    private $type;
    private $label;
    private $length;
    private $num_decimals;
    private $picklist_values = array();
    
    const DEFAULT_FIELD_LENGTH = 32;
    const DEFAULT_NUM_DECIMALS = 0;

    const DEFAULT_ROWS = 32;
    const DEFAULT_COLS = 64;
    
    private function __construct($key,$type,$label,$length=self::DEFAULT_FIELD_LENGTH,$num_decimals=self::DEFAULT_NUM_DECIMALS,$picklist_values=array())
    {
        $this->key = $key;
        $this->type = $type;
        $this->label = $label;
        $this->length = $length;
        $this->num_decimals = $num_decimals;
        $this->picklist_values = $picklist_values;
    }
    
    private function get_label_id($nome_form,$rendering_count)
    {
        $full_id = $nome_form."_".$rendering_count."_".$this->key;
        return "l_".$full_id;
    }
    
    private function get_field_id($nome_form,$rendering_count)
    {
        $full_id = $nome_form."_".$rendering_count."_".$this->key;
        return "f_".$full_id;
    }
    
    public function write_label($nome_form,$rendering_count)
    {
        $label_id = $this->get_label_id($nome_form, $rendering_count);
        $field_id = $this->get_field_id($nome_form, $rendering_count);
        
        echo "<label id='$label_id' for='".$field_id."'>";
        echo $this->label;
        echo "</label>";
    }
    
    public function read_value()
    {
        return Params::get($this->key);
    }
    
    public function write_field($nome_form,$rendering_count,$value=null)
    {
        $id = $this->get_field_id($nome_form, $rendering_count);
        $name = $this->key;
        $length = $this->length;
        $picklist_values = $this->picklist_values;
        $num_decimals = $this->num_decimals;
        $rows = self::DEFAULT_ROWS;
        $cols = self::DEFAULT_COLS;
        include(FRAMEWORK_CORE_PATH."forms/html/".$this->type.".inc.php");
    }
    
}
?>