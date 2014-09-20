<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class OldForm extends BasicObject
{
    private static $forms = array();
    public static $current_form = null;

    public static function open_upload($form_name,$action_url="",$method="POST",$default_azione="")
    {
        fg_ex_param_defined_not_empty($form_name, "Il nome della form deve essere specificato.");
        
        if (self::$current_form==null)
        {
            self::$current_form = $form_name;
 
        }
        else throw new Exception("Una form risulta gia aperta.");

        if (!isset ($action_url) || $action_url=="")
            $action_url = $_SERVER['PHP_SELF'];
        ?>

        <form name="<?=$form_name ?>" method="<?=$method ?>" action="<?=$action_url ?>" enctype="multipart/form-data">
        <input id="<?=Form::$current_form ?>_id_azione_form" type="hidden" name="azione" value="<?=$default_azione ?>" >

        <?php
        if (array_key_exists($form_name, self::$forms))
        {
            $object = self::$forms[$form_name];
        ?>
        <input type="hidden" name="id" value="<?=$object->__ID ?>" />
        
        <?php
        }
    }

    public static function open($form_name,$action_url="",$method="POST",$default_azione="")
    {
        fg_ex_param_defined_not_empty($form_name, "Il nome della form deve essere specificato.");

        if (self::$current_form==null)
        {
            self::$current_form = $form_name;
        }
        else throw new Exception("Una form risulta gia aperta.");

        if (!isset ($action_url) || $action_url=="")
            $action_url = $_SERVER['PHP_SELF'];
    ?>

    <form name="<?=$form_name ?>" method="<?=$method ?>" action="<?=$action_url ?>">
    <input id="<?=Form::$current_form ?>_id_azione_form" type="hidden" name="azione" value="<?=$default_azione ?>" >

    <?php
    }

    public static function button($base_images_path,$button_id,$alt_text,$action)
    {
        fg_check_start_with_slash($base_images_path);

        $img_selected = $base_images_path."_selected.png";
        $img_not_selected = $base_images_path."_not_selected.png";
        $img_mouse_over = $base_images_path."_mouse_over.png";

        ?>

        <input onclick="fg_update_azione_form('<?=self::$current_form ?>','<?=$action ?>')" type="image" id="<?=$button_id ?>" onmousedown="this.src='<?=$img_selected?>'" onmouseout="this.src='<?=$img_not_selected ?>'" onmouseover="this.src='<?=$img_mouse_over ?>'" src="<?=$img_not_selected ?>" >

        <?php
    }
    
    public static function close()
    {
        
        if (Form::$current_form!=null)
        {
            echo "</form>";
            self::$current_form = null;

        }
        else throw new Exception("Non ci sono form gi&agrave; aperte!");
    }
    
    public static function writeSelectGiorno($field_name,$giorno=-1)
    {
        $yes_selected = "selected=\"selected\"";
        $no_selected = "";

        echo "<select class=\"form_field_enabled\" name=\"$field_name\">";
        $selected = $giorno == -1 ? $yes_selected : $no_selected;
        echo "<option value=\"-1\" $selected>&nbsp;&nbsp;&nbsp;&nbsp;</option>\n";
        for ($d=1;$d<32;$d++)
        {
            if ($giorno==$d)
            $selected = $yes_selected;
            else
            $selected = $no_selected;
            echo "<option value=\"$d\" $selected>$d</option>\n";
        }
        echo "</select>\n";
    }
    
    public static function writeSelectMese()
    {
        $yes_selected = "selected=\"selected\"";
        $no_selected = "";

        echo "<select class=\"form_field_enabled\" name=\"$field_name\">";
        $selected = $mese == -1 ? $yes_selected : $no_selected;
        echo "<option value=\"-1\" $selected>&nbsp;&nbsp;&nbsp;&nbsp;</option>\n";
        for ($m=1;$m<13;$m++)
        {
            if ($mese==$m)
            $selected = $yes_selected;
            else
            $selected = $no_selected;
            echo "<option value=\"$m\" $selected>$m</option>\n";
        }
        echo "</select>\n";
    }
    
    public static function writeSelectAnno($field_name,$anno="")
    {
        $value_anno = $anno==0 ? "" : $anno;
        echo "<input  class=\"form_field_enabled\" type=\"text\" name=\"$field_name\" size=\"4\" value=\"$value_anno\">";

    }

    public static function registerObject($form_name,$object)
    {
        self::$forms[$form_name] = $object;
    }
}

?>